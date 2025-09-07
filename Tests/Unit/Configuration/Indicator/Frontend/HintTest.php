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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Hint;
use PHPUnit\Framework\TestCase;

/**
 * HintTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class HintTest extends TestCase
{
    public function testConstructorWithEmptyConfiguration(): void
    {
        $hint = new Hint();
        self::assertInstanceOf(Hint::class, $hint);
    }

    public function testConstructorWithConfiguration(): void
    {
        $config = [
            'color' => '#ff0000',
            'text' => 'Development',
            'position' => 'bottom right',
        ];
        $hint = new Hint($config);
        self::assertEquals($config, $hint->getConfiguration());
    }

    public function testGetConfigurationReturnsConfiguration(): void
    {
        $config = [
            'color' => '#00ff00',
            'text' => 'Testing',
            'position' => 'top left',
        ];
        $hint = new Hint($config);
        self::assertEquals($config, $hint->getConfiguration());
    }

    public function testInheritsFromAbstractIndicator(): void
    {
        $hint = new Hint();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\AbstractIndicator::class, $hint);
    }

    public function testImplementsIndicatorInterface(): void
    {
        $hint = new Hint();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface::class, $hint);
    }
}
