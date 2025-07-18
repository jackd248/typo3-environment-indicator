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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service\ConfigurationStorage;
use PHPUnit\Framework\TestCase;

class ConfigurationStorageTest extends TestCase
{
    private ConfigurationStorage $configurationStorage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configurationStorage = new ConfigurationStorage();

        // Clear global state
        unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]);
    }

    protected function tearDown(): void
    {
        // Clear global state
        unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]);
        parent::tearDown();
    }

    public function testAddConfiguration(): void
    {
        $configuration = ['test' => 'value'];
        $this->configurationStorage->addConfiguration($configuration);

        $configurations = $this->configurationStorage->getConfigurations();
        self::assertCount(1, $configurations);
        self::assertEquals($configuration, $configurations[0]);
    }

    public function testGetConfigurationsReturnsEmptyArrayWhenNotSet(): void
    {
        $configurations = $this->configurationStorage->getConfigurations();
        self::assertEmpty($configurations);
    }

    public function testHasConfigurationsReturnsFalseWhenNotSet(): void
    {
        self::assertFalse($this->configurationStorage->hasConfigurations());
    }

    public function testHasConfigurationsReturnsTrueWhenSet(): void
    {
        $this->configurationStorage->addConfiguration(['test' => 'value']);
        self::assertTrue($this->configurationStorage->hasConfigurations());
    }

    public function testGetCurrentIndicatorsReturnsEmptyArrayWhenNotSet(): void
    {
        $indicators = $this->configurationStorage->getCurrentIndicators();
        self::assertEmpty($indicators);
    }

    public function testHasCurrentIndicatorsReturnsFalseWhenNotSet(): void
    {
        self::assertFalse($this->configurationStorage->hasCurrentIndicators());
    }

    public function testSetCurrentIndicator(): void
    {
        $this->configurationStorage->setCurrentIndicator('TestClass', ['config' => 'value']);

        $indicators = $this->configurationStorage->getCurrentIndicators();
        self::assertArrayHasKey('TestClass', $indicators);
        self::assertEquals(['config' => 'value'], $indicators['TestClass']);
        self::assertTrue($this->configurationStorage->hasCurrentIndicators());
    }

    public function testMergeCurrentIndicatorWithExisting(): void
    {
        $this->configurationStorage->setCurrentIndicator('TestClass', ['config1' => 'value1']);
        $this->configurationStorage->mergeCurrentIndicator('TestClass', ['config2' => 'value2']);

        $indicators = $this->configurationStorage->getCurrentIndicators();
        self::assertEquals([
            'config1' => 'value1',
            'config2' => 'value2',
        ], $indicators['TestClass']);
    }

    public function testMergeCurrentIndicatorWithoutExisting(): void
    {
        $this->configurationStorage->mergeCurrentIndicator('TestClass', ['config' => 'value']);

        $indicators = $this->configurationStorage->getCurrentIndicators();
        self::assertEquals(['config' => 'value'], $indicators['TestClass']);
    }
}
