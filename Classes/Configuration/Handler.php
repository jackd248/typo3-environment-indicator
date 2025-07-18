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

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service\ConfigurationStorage;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service\IndicatorResolver;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service\TriggerEvaluator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Main handler class for managing environment indicator configuration.
 *
 * This class acts as a facade for the configuration management system,
 * delegating responsibilities to specialized service classes.
 */
class Handler
{
    private static ?IndicatorResolver $indicatorResolver = null;
    private static ?ConfigurationStorage $configurationStorage = null;
    private static ?TriggerEvaluator $triggerEvaluator = null;

    /**
     * Adds a new indicator/trigger configuration.
     *
     * @param TriggerInterface[] $triggers Array of trigger objects
     * @param IndicatorInterface[] $indicators Array of indicator objects
     */
    public static function addIndicator(array $triggers = [], array $indicators = []): void
    {
        if (!self::validateConfiguration($triggers, $indicators)) {
            return;
        }

        $configuration = [
            'triggers' => $triggers,
            'indicators' => $indicators,
        ];

        $configurationStorage = self::getConfigurationStorage();

        if ($configurationStorage->hasConfigurations() || $triggers !== [] || $indicators !== []) {
            $configurationStorage->addConfiguration($configuration);
        }
    }

    /**
     * Resolves the current indicators based on the registered configurations and the checked triggers.
     *
     * @return array Current indicators
     */
    public static function resolveIndicators(): array
    {
        return self::getIndicatorResolver()->resolveIndicators();
    }

    /**
     * Validates the configuration input.
     *
     * @param array $triggers Array of potential trigger objects
     * @param array $indicators Array of potential indicator objects
     * @return bool True if configuration is valid, false otherwise
     */
    private static function validateConfiguration(array $triggers, array $indicators): bool
    {
        if ($triggers === [] && $indicators === []) {
            return false;
        }

        $triggerEvaluator = self::getTriggerEvaluator();
        $indicatorResolver = self::getIndicatorResolver();

        if ($triggers !== [] && !$triggerEvaluator->validateTriggers($triggers)) {
            return false;
        }

        if ($indicators !== [] && !$indicatorResolver->validateIndicators($indicators)) {
            return false;
        }

        return true;
    }

    /**
     * Gets the configuration storage service.
     *
     * @return ConfigurationStorage
     */
    private static function getConfigurationStorage(): ConfigurationStorage
    {
        if (self::$configurationStorage === null) {
            self::$configurationStorage = GeneralUtility::makeInstance(ConfigurationStorage::class);
        }

        return self::$configurationStorage;
    }

    /**
     * Gets the trigger evaluator service.
     *
     * @return TriggerEvaluator
     */
    private static function getTriggerEvaluator(): TriggerEvaluator
    {
        if (self::$triggerEvaluator === null) {
            self::$triggerEvaluator = GeneralUtility::makeInstance(TriggerEvaluator::class);
        }

        return self::$triggerEvaluator;
    }

    /**
     * Gets the indicator resolver service.
     *
     * @return IndicatorResolver
     */
    private static function getIndicatorResolver(): IndicatorResolver
    {
        if (self::$indicatorResolver === null) {
            $configurationStorage = self::getConfigurationStorage();
            $triggerEvaluator = self::getTriggerEvaluator();

            self::$indicatorResolver = GeneralUtility::makeInstance(
                IndicatorResolver::class,
                $configurationStorage,
                $triggerEvaluator
            );
        }

        return self::$indicatorResolver;
    }
}
