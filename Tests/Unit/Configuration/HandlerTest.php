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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]);
    }

    public function testAddIndicatorWithEmptyArraysDoesNothing(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'] = [];

        Handler::addIndicator([], []);

        self::assertEquals([], $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration']);
    }

    public function testAddIndicatorWithTriggerAndIndicator(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'] = [];

        $trigger = $this->createMock(TriggerInterface::class);
        $indicator = $this->createMock(IndicatorInterface::class);

        Handler::addIndicator([$trigger], [$indicator]);

        self::assertCount(1, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration']);
        $config = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'];
        self::assertNotEmpty($config);
        self::assertArrayHasKey(0, $config);
        /** @var array{triggers: array, indicators: array} $firstConfig */
        $firstConfig = $config[0];
        self::assertCount(1, $firstConfig['triggers']);
        self::assertCount(1, $firstConfig['indicators']);
    }

    public function testResolveIndicatorsWithEmptyGlobals(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'] = [];

        $result = Handler::resolveIndicators();

        self::assertEquals([], $result);
    }

    public function testResolveIndicatorsWithExistingCurrent(): void
    {
        $expected = ['test' => 'value'];
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = $expected;

        $result = Handler::resolveIndicators();

        self::assertEquals($expected, $result);
    }

    public function testResolveIndicatorsWithFailingTrigger(): void
    {
        $trigger = $this->createMock(TriggerInterface::class);
        $trigger->expects(self::once())->method('check')->willReturn(false);

        $indicator = $this->createMock(IndicatorInterface::class);
        $indicator->expects(self::never())->method('getConfiguration');

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'] = [
            [
                'triggers' => [$trigger],
                'indicators' => [$indicator],
            ],
        ];

        $result = Handler::resolveIndicators();

        self::assertEquals([], $result);
    }

    public function testResolveIndicatorsWithPassingTrigger(): void
    {
        $trigger = $this->createMock(TriggerInterface::class);
        $trigger->expects(self::once())->method('check')->willReturn(true);

        $indicator = $this->createMock(IndicatorInterface::class);
        $indicator->expects(self::once())->method('getConfiguration')->willReturn(['test' => 'value']);

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'] = [
            [
                'triggers' => [$trigger],
                'indicators' => [$indicator],
            ],
        ];

        $result = Handler::resolveIndicators();

        self::assertEquals([get_class($indicator) => ['test' => 'value']], $result);
    }
}
