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

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use Psr\Http\Message\ServerRequestInterface;

/**
 * AbstractIndicator.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
abstract class AbstractIndicator
{
    public function __construct(protected array $configuration = [], protected ?ServerRequestInterface $request = null)
    {
        $this->configuration = $this->mergeGlobalConfiguration($this->configuration);
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    protected function mergeGlobalConfiguration(array $configuration): array
    {
        $globalConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'] ?? [];
        return is_array($globalConfiguration) && array_key_exists(static::class, $globalConfiguration) ? array_replace_recursive($globalConfiguration[static::class], $configuration) : $configuration;
    }
}
