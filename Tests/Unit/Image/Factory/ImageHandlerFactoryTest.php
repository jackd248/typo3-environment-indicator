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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Image\Factory;

use KonradMichalik\Typo3EnvironmentIndicator\Image\BackendLogoHandler;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Factory\ImageHandlerFactory;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Factory\ImageHandlerFactoryInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FaviconHandler;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FrontendImageHandler;
use PHPUnit\Framework\TestCase;

class ImageHandlerFactoryTest extends TestCase
{
    private ImageHandlerFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ImageHandlerFactory();
    }

    public function testImplementsInterface(): void
    {
        self::assertInstanceOf(ImageHandlerFactoryInterface::class, $this->factory);
    }

    public function testCreateBackendLogoHandler(): void
    {
        $handler = $this->factory->createBackendLogoHandler();
        self::assertInstanceOf(BackendLogoHandler::class, $handler);
    }

    public function testCreateFaviconHandler(): void
    {
        $handler = $this->factory->createFaviconHandler();
        self::assertInstanceOf(FaviconHandler::class, $handler);
    }

    public function testCreateFrontendImageHandler(): void
    {
        $handler = $this->factory->createFrontendImageHandler();
        self::assertInstanceOf(FrontendImageHandler::class, $handler);
    }

    public function testCreateHandlerWithBackendLogoType(): void
    {
        $handler = $this->factory->createHandler('backend_logo');
        self::assertInstanceOf(BackendLogoHandler::class, $handler);
    }

    public function testCreateHandlerWithFaviconType(): void
    {
        $handler = $this->factory->createHandler('favicon');
        self::assertInstanceOf(FaviconHandler::class, $handler);
    }

    public function testCreateHandlerWithFrontendImageType(): void
    {
        $handler = $this->factory->createHandler('frontend_image');
        self::assertInstanceOf(FrontendImageHandler::class, $handler);
    }

    public function testCreateHandlerWithInvalidType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1726357770);
        $this->expectExceptionMessage('Unsupported handler type: invalid');

        $this->factory->createHandler('invalid');
    }

    public function testGetSupportedHandlerTypes(): void
    {
        $types = $this->factory->getSupportedHandlerTypes();

        self::assertContains('backend_logo', $types);
        self::assertContains('favicon', $types);
        self::assertContains('frontend_image', $types);
        self::assertCount(3, $types);
    }
}
