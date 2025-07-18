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

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;

/**
 * Service for resolving and processing indicators.
 *
 * This service handles the resolution of indicators based on
 * configuration and trigger evaluation results.
 */
class IndicatorResolver
{
    private ConfigurationStorage $configurationStorage;
    private TriggerEvaluator $triggerEvaluator;

    public function __construct(
        ConfigurationStorage $configurationStorage,
        TriggerEvaluator $triggerEvaluator
    ) {
        $this->configurationStorage = $configurationStorage;
        $this->triggerEvaluator = $triggerEvaluator;
    }

    /**
     * Resolves all active indicators based on current configuration and triggers.
     *
     * @return array Array of resolved indicators
     */
    public function resolveIndicators(): array
    {
        if ($this->configurationStorage->hasCurrentIndicators()) {
            return $this->configurationStorage->getCurrentIndicators();
        }

        $configurations = $this->configurationStorage->getConfigurations();
        foreach ($configurations as $configuration) {
            $this->processConfiguration($configuration);
        }

        return $this->configurationStorage->getCurrentIndicators();
    }

    /**
     * Processes a single configuration entry.
     *
     * @param array $configuration The configuration to process
     */
    protected function processConfiguration(array $configuration): void
    {
        $triggers = $configuration['triggers'] ?? [];
        $indicators = $configuration['indicators'] ?? [];

        if ($indicators === []) {
            return;
        }

        if (!$this->triggerEvaluator->evaluateTriggers($triggers)) {
            return;
        }

        foreach ($indicators as $indicator) {
            $this->processIndicator($indicator);
        }
    }

    /**
     * Processes a single indicator.
     *
     * @param IndicatorInterface $indicator The indicator to process
     */
    protected function processIndicator(IndicatorInterface $indicator): void
    {
        try {
            $indicatorClass = $indicator::class;
            $configuration = $indicator->getConfiguration();

            // Merge with existing configuration or set new one
            $this->configurationStorage->mergeCurrentIndicator($indicatorClass, $configuration);
        } catch (\Throwable $e) {
            // Log error but don't break the entire resolution
            error_log('Indicator processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Validates that indicators are properly configured.
     *
     * @param array $indicators Array of potential indicator objects
     * @return bool True if all indicators are valid, false otherwise
     */
    public function validateIndicators(array $indicators): bool
    {
        foreach ($indicators as $indicator) {
            if (!$indicator instanceof IndicatorInterface) {
                return false;
            }
        }

        return true;
    }
}
