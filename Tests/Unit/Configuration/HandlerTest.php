<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;
use PHPUnit\Framework\TestCase;

/**
 * HandlerTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
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

        self::assertEquals([$indicator::class => ['test' => 'value']], $result);
    }
}
