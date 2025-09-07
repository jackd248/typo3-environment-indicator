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

use Intervention\Image\Geometry\Factories\CircleFactory;
use Intervention\Image\Interfaces\ImageInterface;

/**
 * CircleModifier.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class CircleModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $width = $image->width();
        $height = $image->height();

        $circleSize = (int)($width * $this->configuration['size']);
        $radius = (int)($circleSize / 2);

        $paddingPercent = $this->configuration['padding'];
        $paddingX = (int)($width * $paddingPercent);
        $paddingY = (int)($height * $paddingPercent);

        $x = $width - $radius - $paddingX;
        $y = $height - $radius - $paddingY;

        switch ($this->configuration['position']) {
            case 'top left':
                $x = $radius + $paddingX;
                $y = $radius + $paddingY;
                break;
            case 'top right':
                $x = $width - $radius - $paddingX;
                $y = $radius + $paddingY;
                break;
            case 'bottom left':
                $x = $radius + $paddingX;
                $y = $height - $radius - $paddingY;
                break;
            case 'bottom right':
            default:
                break;
        }

        $image->drawCircle(
            $x,
            $y,
            function (CircleFactory $circle) use ($radius) {
                $circle->radius($radius);
                $circle->background($this->configuration['color']);
            }
        );
    }

    public function validateConfigurationWithErrors(array $configuration): array
    {
        $errors = [];

        // Validate required color
        if (!isset($configuration['color'])) {
            $errors[] = 'Missing required configuration key: color';
        } elseif (!is_string($configuration['color'])) {
            $errors[] = 'Configuration key "color" must be a string';
        }

        // Validate required size
        if (!isset($configuration['size'])) {
            $errors[] = 'Missing required configuration key: size';
        } elseif (!is_numeric($configuration['size'])) {
            $errors[] = 'Configuration key "size" must be numeric';
        } elseif ($configuration['size'] < 0 || $configuration['size'] > 1) {
            $errors[] = 'Configuration key "size" must be between 0 and 1';
        }

        // Validate required padding
        if (!isset($configuration['padding'])) {
            $errors[] = 'Missing required configuration key: padding';
        } elseif (!is_numeric($configuration['padding'])) {
            $errors[] = 'Configuration key "padding" must be numeric';
        } elseif ($configuration['padding'] < 0 || $configuration['padding'] > 1) {
            $errors[] = 'Configuration key "padding" must be between 0 and 1';
        }

        // Validate required position
        if (!isset($configuration['position'])) {
            $errors[] = 'Missing required configuration key: position';
        } elseif (!is_string($configuration['position'])) {
            $errors[] = 'Configuration key "position" must be a string';
        } else {
            $validPositions = ['top left', 'top center', 'top right', 'center left', 'center', 'center right', 'bottom left', 'bottom center', 'bottom right'];
            if (!in_array($configuration['position'], $validPositions, true)) {
                $errors[] = 'Configuration key "position" must be one of: ' . implode(', ', $validPositions);
            }
        }

        return [
            'valid' => $errors === [],
            'errors' => $errors,
        ];
    }
}
