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
use KonradMichalik\Typo3EnvironmentIndicator\Image\BackendLogoHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * BackendLogoMiddleware.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class BackendLogoMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (($this->extensionConfiguration->get(Configuration::EXT_KEY)['backend']['logo'] ?? false) === true) {
            $currentBackendLogo = $this->getBackendLogo($this->extensionConfiguration, $request);
            $imageHandler = GeneralUtility::makeInstance(BackendLogoHandler::class);
            $newBackendLogo = $imageHandler->process($currentBackendLogo, $request);
            $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendLogo'] = $newBackendLogo;
        }

        return $handler->handle($request);
    }

    protected function getBackendLogo(ExtensionConfiguration $extensionConfiguration, ServerRequestInterface $request): string
    {
        $backendLogo = $extensionConfiguration->get('backend', 'backendLogo');
        if ($backendLogo !== null && $backendLogo !== '') {
            return $backendLogo;
        }
        return 'EXT:backend/Resources/Public/Images/typo3_logo_orange.svg';
    }
}
