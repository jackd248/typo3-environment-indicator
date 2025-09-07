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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\ExpressionLanguage;

use KonradMichalik\Typo3EnvironmentIndicator\ExpressionLanguage\TechnicalContextTypoScriptConditionProvider;
use KonradMichalik\Typo3EnvironmentIndicator\TypoScript\TechnicalContextConditionFunctionsProvider;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

/**
 * TechnicalContextTypoScriptConditionProviderTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class TechnicalContextTypoScriptConditionProviderTest extends TestCase
{
    public function testConstructorSetsExpressionLanguageProviders(): void
    {
        $provider = new TechnicalContextTypoScriptConditionProvider();
        self::assertInstanceOf(TechnicalContextTypoScriptConditionProvider::class, $provider);
    }

    public function testExtendsAbstractProvider(): void
    {
        $provider = new TechnicalContextTypoScriptConditionProvider();
        self::assertInstanceOf(AbstractProvider::class, $provider);
    }

    public function testExpressionLanguageProvidersContainsTechnicalContextConditionFunctionsProvider(): void
    {
        $provider = new TechnicalContextTypoScriptConditionProvider();
        $reflection = new \ReflectionClass($provider);
        $property = $reflection->getProperty('expressionLanguageProviders');
        $property->setAccessible(true);
        $providers = $property->getValue($provider);

        self::assertIsArray($providers);
        self::assertCount(1, $providers);
        self::assertEquals(TechnicalContextConditionFunctionsProvider::class, $providers[0]);
    }
}
