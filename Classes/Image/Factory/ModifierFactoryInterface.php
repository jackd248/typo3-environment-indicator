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

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Factory;

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\ModifierInterface;

/**
 * ModifierFactoryInterface.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
interface ModifierFactoryInterface
{
    /**
     * Creates a modifier instance by type and configuration.
     *
     * @param string $type The modifier type
     * @param array $configuration The modifier configuration
     * @return ModifierInterface
     * @throws \InvalidArgumentException If the modifier type is not supported or configuration is invalid
     */
    public function createModifier(string $type, array $configuration): ModifierInterface;

    /**
     * Returns the list of supported modifier types.
     *
     * @return array<string> Array of supported modifier type names
     */
    public function getSupportedModifierTypes(): array;

    /**
     * Validates configuration for a specific modifier type.
     *
     * @param string $type The modifier type
     * @param array $configuration The configuration to validate
     * @return bool True if configuration is valid, false otherwise
     */
    public function validateConfiguration(string $type, array $configuration): bool;
}
