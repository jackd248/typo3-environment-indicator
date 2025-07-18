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

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\CircleModifier;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\ColorizeModifier;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\FrameModifier;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\ModifierInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\OverlayModifier;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\ReplaceModifier;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\TextModifier;
use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\TriangleModifier;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Factory for creating image modifiers with proper configuration validation.
 *
 * This factory centralizes modifier creation logic and provides consistent
 * configuration validation across all modifier types.
 */
class ModifierFactory implements ModifierFactoryInterface
{
    private const MODIFIER_MAP = [
        'circle' => CircleModifier::class,
        'colorize' => ColorizeModifier::class,
        'frame' => FrameModifier::class,
        'overlay' => OverlayModifier::class,
        'replace' => ReplaceModifier::class,
        'text' => TextModifier::class,
        'triangle' => TriangleModifier::class,
    ];

    public function createModifier(string $type, array $configuration): ModifierInterface
    {
        if (!isset(self::MODIFIER_MAP[$type])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unsupported modifier type: %s. Supported types: %s',
                    $type,
                    implode(', ', array_keys(self::MODIFIER_MAP))
                ),
                1726357771
            );
        }

        if (!$this->validateConfiguration($type, $configuration)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid configuration for modifier type: %s', $type),
                1726357772
            );
        }

        $modifierClass = self::MODIFIER_MAP[$type];

        try {
            return GeneralUtility::makeInstance($modifierClass, $configuration);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException(
                sprintf('Failed to create modifier of type: %s. Error: %s', $type, $e->getMessage()),
                1726357773,
                $e
            );
        }
    }

    public function getSupportedModifierTypes(): array
    {
        return array_keys(self::MODIFIER_MAP);
    }

    public function validateConfiguration(string $type, array $configuration): bool
    {
        if (!isset(self::MODIFIER_MAP[$type])) {
            return false;
        }

        try {
            $modifierClass = self::MODIFIER_MAP[$type];

            $reflectionClass = new \ReflectionClass($modifierClass);
            return $reflectionClass->newInstanceWithoutConstructor()->validateConfiguration($configuration);
        } catch (\Throwable $e) {
            return false;
        }
    }

}
