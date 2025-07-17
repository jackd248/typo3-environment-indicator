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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Indicator\Frontend;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testConstructorWithEmptyConfiguration(): void
    {
        $image = new Image();
        self::assertInstanceOf(Image::class, $image);
    }

    public function testConstructorWithConfiguration(): void
    {
        $config = [
            'modifiers' => [
                'circle' => [
                    'color' => '#ff0000',
                    'size' => 0.3,
                    'position' => 'top right',
                ],
            ],
        ];
        $image = new Image($config);
        self::assertEquals($config, $image->getConfiguration());
    }

    public function testGetConfigurationReturnsConfiguration(): void
    {
        $config = [
            'modifiers' => [
                'text' => [
                    'text' => 'DEV',
                    'color' => '#ffffff',
                    'size' => 16,
                ],
            ],
        ];
        $image = new Image($config);
        self::assertEquals($config, $image->getConfiguration());
    }

    public function testInheritsFromAbstractIndicator(): void
    {
        $image = new Image();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\AbstractIndicator::class, $image);
    }

    public function testImplementsIndicatorInterface(): void
    {
        $image = new Image();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface::class, $image);
    }
}
