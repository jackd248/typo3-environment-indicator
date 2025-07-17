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

use Intervention\Image\Interfaces\DriverInterface;
use Intervention\Image\Interfaces\ImageManagerInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use PHPUnit\Framework\TestCase;

class GeneralHelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [];
    }

    public function testSupportFormatWithIco(): void
    {
        $manager = $this->createMock(ImageManagerInterface::class);
        $result = GeneralHelper::supportFormat($manager, 'ico');
        self::assertTrue($result);
    }

    public function testSupportFormatWithSvg(): void
    {
        $manager = $this->createMock(ImageManagerInterface::class);
        $result = GeneralHelper::supportFormat($manager, 'svg');
        self::assertTrue($result);
    }

    public function testSupportFormatWithSupportedFormat(): void
    {
        $driver = $this->createMock(DriverInterface::class);
        $driver->expects(self::once())
            ->method('supports')
            ->with('jpg')
            ->willReturn(true);

        $manager = $this->createMock(ImageManagerInterface::class);
        $manager->expects(self::once())
            ->method('driver')
            ->willReturn($driver);

        $result = GeneralHelper::supportFormat($manager, 'jpg');
        self::assertTrue($result);
    }

    public function testSupportFormatWithUnsupportedFormat(): void
    {
        $driver = $this->createMock(DriverInterface::class);
        $driver->expects(self::once())
            ->method('supports')
            ->with('unknown')
            ->willReturn(false);

        $manager = $this->createMock(ImageManagerInterface::class);
        $manager->expects(self::once())
            ->method('driver')
            ->willReturn($driver);

        $result = GeneralHelper::supportFormat($manager, 'unknown');
        self::assertFalse($result);
    }

    public function testIsCurrentIndicatorWithExistingIndicator(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [
            'TestIndicator' => ['config' => 'value'],
        ];

        $result = GeneralHelper::isCurrentIndicator('TestIndicator');
        self::assertTrue($result);
    }

    public function testIsCurrentIndicatorWithNonExistingIndicator(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [];

        $result = GeneralHelper::isCurrentIndicator('NonExistingIndicator');
        self::assertFalse($result);
    }

    public function testGetIndicatorConfigurationReturnsExpectedArray(): void
    {
        $expected = ['test' => 'value'];
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = $expected;

        $result = GeneralHelper::getIndicatorConfiguration();
        self::assertEquals($expected, $result);
    }
}
