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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Indicator;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\AbstractIndicator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class AbstractIndicatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults']);
    }

    public function testConstructorWithEmptyConfiguration(): void
    {
        $indicator = new ConcreteIndicator();
        self::assertEquals([], $indicator->getConfiguration());
    }

    public function testConstructorWithConfiguration(): void
    {
        $config = ['key' => 'value'];
        $indicator = new ConcreteIndicator($config);
        self::assertEquals($config, $indicator->getConfiguration());
    }

    public function testConstructorWithRequest(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $config = ['key' => 'value'];
        $indicator = new ConcreteIndicator($config, $request);
        self::assertEquals($config, $indicator->getConfiguration());
    }

    public function testMergeGlobalConfigurationWithNoGlobal(): void
    {
        $config = ['key' => 'value'];
        $indicator = new ConcreteIndicator($config);
        self::assertEquals($config, $indicator->getConfiguration());
    }

    public function testMergeGlobalConfigurationWithGlobal(): void
    {
        $globalConfig = [
            ConcreteIndicator::class => [
                'global' => 'value',
                'override' => 'global',
            ],
        ];
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'] = $globalConfig;

        $localConfig = ['local' => 'value', 'override' => 'local'];
        $indicator = new ConcreteIndicator($localConfig);

        $expected = [
            'global' => 'value',
            'local' => 'value',
            'override' => 'local',
        ];
        self::assertEquals($expected, $indicator->getConfiguration());
    }

    public function testMergeGlobalConfigurationWithEmptyGlobal(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'] = [];

        $config = ['key' => 'value'];
        $indicator = new ConcreteIndicator($config);
        self::assertEquals($config, $indicator->getConfiguration());
    }

    public function testMergeGlobalConfigurationWithNonArrayGlobal(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'] = 'not an array';

        $config = ['key' => 'value'];
        $indicator = new ConcreteIndicator($config);
        self::assertEquals($config, $indicator->getConfiguration());
    }
}

class ConcreteIndicator extends AbstractIndicator implements IndicatorInterface
{
    public function getConfiguration(): array
    {
        return parent::getConfiguration();
    }
}
