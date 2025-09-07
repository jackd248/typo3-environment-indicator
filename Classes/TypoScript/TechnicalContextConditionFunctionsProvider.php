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

namespace KonradMichalik\Typo3EnvironmentIndicator\TypoScript;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Hint;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

/**
 * TechnicalContextConditionFunctionsProvider.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class TechnicalContextConditionFunctionsProvider implements ExpressionFunctionProviderInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {}

    public function getFunctions(): array
    {
        return [
            $this->getWebserviceFunction(),
        ];
    }

    protected function getWebserviceFunction(): ExpressionFunction
    {
        $extensionConfiguration = $this->extensionConfiguration;
        return new ExpressionFunction(
            'enableTechnicalContext',
            static fn() => null,
            static function () use ($extensionConfiguration) {
                $extensionConfig = $extensionConfiguration->get(Configuration::EXT_KEY);
                return (bool)($extensionConfig['frontend']['context'] ?? false) === true &&
                    GeneralHelper::isCurrentIndicator(Hint::class);
            }
        );
    }
}
