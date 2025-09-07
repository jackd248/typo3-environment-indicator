<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "typo3_environment_indicator".
 *
 * Copyright (C) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Middleware;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FaviconHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * FrontendFaviconMiddleware.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class FrontendFaviconMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $typo3Version = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();
        $extensionConfig = $this->extensionConfiguration->get(Configuration::EXT_KEY);
        if ((bool)($extensionConfig['frontend']['favicon'] ?? false) === true) {
            if ($typo3Version < 13 &&
                is_array($GLOBALS['TSFE']->pSetup) &&
                array_key_exists('shortcutIcon', $GLOBALS['TSFE']->pSetup) &&
                $GLOBALS['TSFE']->pSetup['shortcutIcon'] !== ''
            ) {
                $currentFrontendFavicon = $GLOBALS['TSFE']->pSetup['shortcutIcon'];
                $faviconHandler = GeneralUtility::makeInstance(FaviconHandler::class);
                $newFrontendFavicon = $faviconHandler->process($currentFrontendFavicon, $request);
                $GLOBALS['TSFE']->pSetup['shortcutIcon'] = $newFrontendFavicon;
            } elseif ($typo3Version >= 13) {
                $typoScript = $request->getAttribute('frontend.typoscript');
                if ($typoScript->hasPage() && array_key_exists('shortcutIcon', $typoScript->getPageArray()) && $typoScript->getPageArray()['shortcutIcon'] !== '') {
                    $typoScriptPageArray = $typoScript->getPageArray();
                    $currentFrontendFavicon = $typoScriptPageArray['shortcutIcon'];
                    $faviconHandler = GeneralUtility::makeInstance(FaviconHandler::class);
                    $newFrontendFavicon = $faviconHandler->process($currentFrontendFavicon, $request);
                    $typoScriptPageArray['shortcutIcon'] = $newFrontendFavicon;
                    $typoScript->setPageArray($typoScriptPageArray);
                }
            }
        }

        return $handler->handle($request);
    }
}
