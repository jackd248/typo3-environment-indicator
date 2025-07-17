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

class AbstractModifier
{
    protected array $configuration = [];

    public function __construct(array $configuration)
    {
        $this->mergeGlobalConfiguration($configuration);
        $this->verifyRequiredArrayKeys($configuration);
        $this->configuration = $configuration;
    }

    public function getRequiredConfigurationKeys(): array
    {
        return [];
    }

    protected function verifyRequiredArrayKeys(array $configuration): void
    {
        $missingKeys = array_diff($this->getRequiredConfigurationKeys(), array_keys($configuration));
        if ($missingKeys !== []) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Missing required configuration keys for %s: %s',
                    static::class,
                    implode(', ', $missingKeys)
                ),
                1740401564
            );
        }
    }

    protected function mergeGlobalConfiguration(array &$configuration): void
    {
        $globalConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'][static::class] ?? [];
        $configuration = array_replace_recursive($globalConfiguration, $configuration);
    }
}
