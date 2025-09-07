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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use PHPUnit\Framework\TestCase;

/**
 * ColorUtilityTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class ColorUtilityTest extends TestCase
{
    public function testGetColoredStringWithName(): void
    {
        $result = ColorUtility::getColoredString('test');
        self::assertStringStartsWith('hsl(', $result);
        self::assertStringEndsWith(')', $result);
    }

    public function testGetColoredStringWithoutName(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = 'Test Site';
        $result = ColorUtility::getColoredString();
        self::assertStringStartsWith('hsl(', $result);
        self::assertStringEndsWith(')', $result);
    }

    public function testGetOptimalTextColorForLightColor(): void
    {
        $result = ColorUtility::getOptimalTextColor('#ffffff');
        self::assertStringStartsWith('rgba(0,0,0,', $result);
    }

    public function testGetOptimalTextColorForDarkColor(): void
    {
        $result = ColorUtility::getOptimalTextColor('#000000');
        self::assertStringStartsWith('rgba(255,255,255,', $result);
    }

    public function testGetOptimalTextColorWithOpacity(): void
    {
        $result = ColorUtility::getOptimalTextColor('#ffffff', 0.5);
        self::assertStringContainsString('0.5', $result);
    }

    public function testColorToRgbWithHex(): void
    {
        $result = ColorUtility::colorToRgb('#ff0000');
        self::assertEquals([255, 0, 0], $result);
    }

    public function testColorToRgbWithShortHex(): void
    {
        $result = ColorUtility::colorToRgb('#f00');
        self::assertEquals([255, 0, 0], $result);
    }

    public function testColorToRgbWithRgb(): void
    {
        $result = ColorUtility::colorToRgb('rgb(255, 0, 0)');
        self::assertEquals([255, 0, 0], $result);
    }

    public function testColorToRgbWithHsl(): void
    {
        $result = ColorUtility::colorToRgb('hsl(0, 100%, 50%)');
        self::assertEquals([255, 0, 0], $result);
    }

    public function testColorToRgbWithInvalidColor(): void
    {
        $result = ColorUtility::colorToRgb('invalid');
        self::assertEquals([0, 0, 0], $result);
    }

    public function testColorToRgbWithStringFallback(): void
    {
        $result = ColorUtility::colorToRgb('invalid', '#ff0000');
        self::assertEquals([255, 0, 0], $result);
    }

    public function testHexToRgb(): void
    {
        $result = ColorUtility::hexToRgb('#ff0000');
        self::assertEquals([255, 0, 0], $result);
    }

    public function testHexToRgbWithShortHex(): void
    {
        $result = ColorUtility::hexToRgb('#f00');
        self::assertEquals([255, 0, 0], $result);
    }

    public function testHslToRgb(): void
    {
        $result = ColorUtility::hslToRgb(0, 100, 50);
        self::assertEquals([255, 0, 0], $result);
    }

    public function testHslToRgbWithBlue(): void
    {
        $result = ColorUtility::hslToRgb(240, 100, 50);
        self::assertEquals([0, 0, 255], $result);
    }

    public function testCalculateLuminance(): void
    {
        $result = ColorUtility::calculateLuminance(255, 255, 255);
        self::assertEquals(1.0, $result);
    }

    public function testCalculateLuminanceBlack(): void
    {
        $result = ColorUtility::calculateLuminance(0, 0, 0);
        self::assertEquals(0.0, $result);
    }
}
