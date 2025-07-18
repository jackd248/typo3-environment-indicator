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
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BackendFaviconMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $extensionConfig = $this->extensionConfiguration->get(Configuration::EXT_KEY);
        if ((bool)($extensionConfig['backend']['favicon'] ?? false) === true) {
            $currentBackendFavicon = $this->getBackendFavicon($this->extensionConfiguration, $request);
            $faviconHandler = GeneralUtility::makeInstance(FaviconHandler::class);
            $newBackendFavicon = $faviconHandler->process($currentBackendFavicon, $request);
            $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendFavicon'] = $newBackendFavicon;
        }

        return $handler->handle($request);
    }

    protected function getBackendFavicon(ExtensionConfiguration $extensionConfiguration, ServerRequestInterface $request): string
    {
        $backendFavicon = $extensionConfiguration->get('backend', 'backendFavicon');
        if ($backendFavicon !== null && $backendFavicon !== '') {
            return $backendFavicon;
        }
        return 'EXT:backend/Resources/Public/Icons/favicon.ico';
    }
}
