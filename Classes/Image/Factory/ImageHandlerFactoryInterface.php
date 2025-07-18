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

use KonradMichalik\Typo3EnvironmentIndicator\Image\BackendLogoHandler;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FaviconHandler;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FrontendImageHandler;

/**
 * Factory interface for creating image handlers.
 *
 * This interface defines the contract for creating different types of image handlers
 * with proper dependency injection and configuration.
 */
interface ImageHandlerFactoryInterface
{
    /**
     * Creates a backend logo handler instance.
     *
     * @return BackendLogoHandler
     */
    public function createBackendLogoHandler(): BackendLogoHandler;

    /**
     * Creates a favicon handler instance.
     *
     * @return FaviconHandler
     */
    public function createFaviconHandler(): FaviconHandler;

    /**
     * Creates a frontend image handler instance.
     *
     * @return FrontendImageHandler
     */
    public function createFrontendImageHandler(): FrontendImageHandler;

    /**
     * Creates a handler by type name.
     *
     * @param string $type The handler type ('backend_logo', 'favicon', 'frontend_image')
     * @return BackendLogoHandler|FaviconHandler|FrontendImageHandler
     * @throws \InvalidArgumentException If the handler type is not supported
     */
    public function createHandler(string $type): BackendLogoHandler|FaviconHandler|FrontendImageHandler;

    /**
     * Returns the list of supported handler types.
     *
     * @return array<string> Array of supported handler type names
     */
    public function getSupportedHandlerTypes(): array;
}
