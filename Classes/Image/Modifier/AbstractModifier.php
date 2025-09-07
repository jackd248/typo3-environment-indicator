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

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;

/**
 * AbstractModifier.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class AbstractModifier
{
    protected array $configuration = [];

    public function __construct(array $configuration)
    {
        $this->mergeGlobalConfiguration($configuration);

        $validationResult = $this->validateConfigurationWithErrors($configuration);
        if (!$validationResult['valid']) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid configuration for %s: %s',
                    static::class,
                    implode(', ', $validationResult['errors'])
                ),
                1740401564
            );
        }

        $this->configuration = $configuration;
    }

    /**
     * Validates the configuration for this modifier.
     * Override this method in subclasses for custom validation logic.
     *
     * @param array $configuration The configuration to validate
     * @return bool True if configuration is valid, false otherwise
     */
    public function validateConfiguration(array $configuration): bool
    {
        return $this->validateConfigurationWithErrors($configuration)['valid'];
    }

    /**
     * Validates the configuration and returns detailed error information.
     * Override this method in subclasses for custom validation logic.
     *
     * @param array $configuration The configuration to validate
     * @return array Array with 'valid' (bool) and 'errors' (array) keys
     */
    public function validateConfigurationWithErrors(array $configuration): array
    {
        return [
            'valid' => true,
            'errors' => [],
        ];
    }

    protected function mergeGlobalConfiguration(array &$configuration): void
    {
        $globalConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'][static::class] ?? [];
        $configuration = array_replace_recursive($globalConfiguration, $configuration);
    }
}
