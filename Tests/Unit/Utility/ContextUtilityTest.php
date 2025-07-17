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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ContextUtility;
use PHPUnit\Framework\TestCase;

class ContextUtilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [];
    }

    public function testGetColorReturnsTransparentWhenNoConfiguration(): void
    {
        $contextUtility = new ContextUtility();
        $color = $contextUtility->getColor();
        self::assertEquals('transparent', $color);
    }

    public function testGetTextColorReturnsColorUtilityResult(): void
    {
        $contextUtility = new ContextUtility();
        $textColor = $contextUtility->getTextColor();
        self::assertStringStartsWith('rgba(', $textColor);
    }

    public function testGetPositionXReturnsCorrectFormat(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [
            \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Hint::class => [
                'position' => 'top right',
            ],
        ];

        $contextUtility = new ContextUtility();
        $positionX = $contextUtility->getPositionX();
        self::assertEquals('top:0', $positionX);
    }

    public function testGetPositionYReturnsCorrectFormat(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [
            \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Hint::class => [
                'position' => 'bottom left',
            ],
        ];

        $contextUtility = new ContextUtility();
        $positionY = $contextUtility->getPositionY();
        self::assertEquals('left:0', $positionY);
    }
}
