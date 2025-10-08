<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Utility;

use Intervention\Image\Interfaces\{DriverInterface, ImageManagerInterface};
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use PHPUnit\Framework\TestCase;

/**
 * GeneralHelperTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
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
