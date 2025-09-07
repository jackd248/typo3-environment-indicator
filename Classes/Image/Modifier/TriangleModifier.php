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

use Intervention\Image\Geometry\Factories\PolygonFactory;
use Intervention\Image\Interfaces\ImageInterface;

/**
 * TriangleModifier.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class TriangleModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $width = $image->width();
        $height = $image->height();

        $triangleSize = (int)($width * $this->configuration['size']);
        $position = $this->configuration['position'] ?? 'bottom right';

        switch ($position) {
            case 'top left':
                $points = [
                    [0, 0],
                    [$triangleSize, 0],
                    [0, $triangleSize],
                ];
                break;
            case 'top right':
                $points = [
                    [$width, 0],
                    [$width - $triangleSize, 0],
                    [$width, $triangleSize],
                ];
                break;
            case 'bottom left':
                $points = [
                    [0, $height],
                    [$triangleSize, $height],
                    [0, $height - $triangleSize],
                ];
                break;
            case 'bottom right':
            default:
                $points = [
                    [$width - $triangleSize, $height],
                    [$width, $height - $triangleSize],
                    [$width, $height],
                ];
                break;
        }

        $image->drawPolygon(function (PolygonFactory $polygon) use ($points) {
            foreach ($points as [$x, $y]) {
                $polygon->point($x, $y);
            }
            $polygon->background($this->configuration['color']);
        });
    }

    public function validateConfiguration(array $configuration): bool
    {
        if (!isset($configuration['color']) || !is_string($configuration['color'])) {
            return false;
        }

        if (isset($configuration['size']) &&
            (!is_numeric($configuration['size']) || $configuration['size'] < 0 || $configuration['size'] > 1)) {
            return false;
        }

        if (isset($configuration['position']) && !is_string($configuration['position'])) {
            return false;
        }

        $validPositions = ['top left', 'top right', 'bottom left', 'bottom right'];
        return !(isset($configuration['position']) && !in_array($configuration['position'], $validPositions, true));
    }
}
