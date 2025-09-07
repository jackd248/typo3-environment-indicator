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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Toolbar;
use PHPUnit\Framework\TestCase;

/**
 * ToolbarTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class ToolbarTest extends TestCase
{
    public function testConstructorWithEmptyConfiguration(): void
    {
        $toolbar = new Toolbar();
        self::assertInstanceOf(Toolbar::class, $toolbar);
    }

    public function testConstructorWithConfiguration(): void
    {
        $config = [
            'color' => '#ff0000',
            'name' => 'Development',
            'index' => 100,
        ];
        $toolbar = new Toolbar($config);
        self::assertEquals($config, $toolbar->getConfiguration());
    }

    public function testGetConfigurationReturnsConfiguration(): void
    {
        $config = [
            'color' => '#00ff00',
            'name' => 'Testing',
            'index' => 200,
        ];
        $toolbar = new Toolbar($config);
        self::assertEquals($config, $toolbar->getConfiguration());
    }

    public function testInheritsFromAbstractIndicator(): void
    {
        $toolbar = new Toolbar();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\AbstractIndicator::class, $toolbar);
    }

    public function testImplementsIndicatorInterface(): void
    {
        $toolbar = new Toolbar();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface::class, $toolbar);
    }
}
