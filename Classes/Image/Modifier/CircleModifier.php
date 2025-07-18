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

    public function validateConfiguration(array $configuration): bool
    {
        if (!isset($configuration['color']) || !is_string($configuration['color'])) {
            return false;
        }

        if (!isset($configuration['size']) || !is_numeric($configuration['size']) ||
            $configuration['size'] < 0 || $configuration['size'] > 1) {
            return false;
        }

        if (!isset($configuration['padding']) || !is_numeric($configuration['padding']) ||
            $configuration['padding'] < 0 || $configuration['padding'] > 1) {
            return false;
        }

        if (!isset($configuration['position']) || !is_string($configuration['position'])) {
            return false;
        }

        $validPositions = ['top left', 'top center', 'top right', 'center left', 'center', 'center right', 'bottom left', 'bottom center', 'bottom right'];
        if (!in_array($configuration['position'], $validPositions, true)) {
            return false;
        }

        return true;
    }
}
