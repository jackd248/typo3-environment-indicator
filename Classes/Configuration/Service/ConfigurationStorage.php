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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;

/**
 * Service for managing configuration storage and retrieval.
 *
 * This service abstracts the access to TYPO3's global configuration
 * and provides a clean interface for configuration operations.
 */
class ConfigurationStorage
{
    /**
     * Adds a configuration entry to the global configuration.
     *
     * @param array $configuration The configuration array to add
     */
    public function addConfiguration(array $configuration): void
    {
        if (!isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'] = [];
        }

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'][] = $configuration;
    }

    /**
     * Retrieves all registered configurations.
     *
     * @return array Array of configuration arrays
     */
    public function getConfigurations(): array
    {
        return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'] ?? [];
    }

    /**
     * Retrieves the current resolved indicators.
     *
     * @return array Current indicators array
     */
    public function getCurrentIndicators(): array
    {
        return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] ?? [];
    }

    /**
     * Checks if current indicators are already resolved.
     *
     * @return bool True if indicators are already resolved, false otherwise
     */
    public function hasCurrentIndicators(): bool
    {
        return ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] ?? []) !== [];
    }

    /**
     * Sets an indicator configuration for the current request.
     *
     * @param string $indicatorClass The indicator class name
     * @param array $configuration The indicator configuration
     */
    public function setCurrentIndicator(string $indicatorClass, array $configuration): void
    {
        if (!isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [];
        }

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicatorClass] = $configuration;
    }

    /**
     * Merges an indicator configuration with existing one.
     *
     * @param string $indicatorClass The indicator class name
     * @param array $configuration The indicator configuration to merge
     */
    public function mergeCurrentIndicator(string $indicatorClass, array $configuration): void
    {
        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicatorClass])) {
            $existing = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicatorClass];
            $merged = array_replace_recursive($existing, $configuration);
            $this->setCurrentIndicator($indicatorClass, $merged);
        } else {
            $this->setCurrentIndicator($indicatorClass, $configuration);
        }
    }

    /**
     * Checks if a configuration storage exists.
     *
     * @return bool True if configuration storage exists, false otherwise
     */
    public function hasConfigurations(): bool
    {
        return isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration']);
    }
}
