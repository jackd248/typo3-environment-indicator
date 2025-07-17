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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Indicator\Backend;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Logo;
use PHPUnit\Framework\TestCase;

class LogoTest extends TestCase
{
    public function testConstructorWithEmptyConfiguration(): void
    {
        $logo = new Logo();
        self::assertInstanceOf(Logo::class, $logo);
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
        $logo = new Logo($config);
        self::assertEquals($config, $logo->getConfiguration());
    }

    public function testGetConfigurationReturnsConfiguration(): void
    {
        $config = [
            'modifiers' => [
                'frame' => [
                    'color' => '#00ff00',
                    'size' => 5,
                ],
            ],
        ];
        $logo = new Logo($config);
        self::assertEquals($config, $logo->getConfiguration());
    }

    public function testInheritsFromAbstractIndicator(): void
    {
        $logo = new Logo();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\AbstractIndicator::class, $logo);
    }

    public function testImplementsIndicatorInterface(): void
    {
        $logo = new Logo();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface::class, $logo);
    }
}
