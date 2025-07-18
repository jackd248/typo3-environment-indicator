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

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Factory;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Logo;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Favicon;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Image;
use KonradMichalik\Typo3EnvironmentIndicator\Image\BackendLogoHandler;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FaviconHandler;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FrontendImageHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Factory for creating image handlers with proper dependency injection.
 *
 * This factory removes the hardcoded dependencies from handler constructors
 * and provides a centralized way to create handlers with their required indicators.
 */
class ImageHandlerFactory implements ImageHandlerFactoryInterface
{
    private const HANDLER_TYPES = [
        'backend_logo' => BackendLogoHandler::class,
        'favicon' => FaviconHandler::class,
        'frontend_image' => FrontendImageHandler::class,
    ];

    public function createBackendLogoHandler(): BackendLogoHandler
    {
        $indicator = GeneralUtility::makeInstance(Logo::class);
        return new BackendLogoHandler($indicator);
    }

    public function createFaviconHandler(): FaviconHandler
    {
        $indicator = GeneralUtility::makeInstance(Favicon::class);
        return new FaviconHandler($indicator);
    }

    public function createFrontendImageHandler(): FrontendImageHandler
    {
        $indicator = GeneralUtility::makeInstance(Image::class);
        return new FrontendImageHandler($indicator);
    }

    public function createHandler(string $type): BackendLogoHandler|FaviconHandler|FrontendImageHandler
    {
        return match ($type) {
            'backend_logo' => $this->createBackendLogoHandler(),
            'favicon' => $this->createFaviconHandler(),
            'frontend_image' => $this->createFrontendImageHandler(),
            default => throw new \InvalidArgumentException(
                sprintf(
                    'Unsupported handler type: %s. Supported types: %s',
                    $type,
                    implode(', ', array_keys(self::HANDLER_TYPES))
                ),
                1726357770
            ),
        };
    }

    public function getSupportedHandlerTypes(): array
    {
        return array_keys(self::HANDLER_TYPES);
    }
}
