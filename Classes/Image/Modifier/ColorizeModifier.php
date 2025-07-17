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

use Intervention\Image\Interfaces\ImageInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ImageDriverUtility;

class ColorizeModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        if (ImageDriverUtility::getImageDriverConfiguration() !== 'imagick') {
            throw new \RuntimeException('This modifier requires the Imagick driver', 1741785764);
        }

        $targetColorArray = ColorUtility::colorToRgb($this->configuration['color']);
        $opacityPercentage = ($this->configuration['opacity'] * 100) . '%';
        $targetColor = sprintf('rgb(%d, %d, %d)', $targetColorArray[0], $targetColorArray[1], $targetColorArray[2]);

        $imagick = $image->core()->native();
        $imagick->modulateImage(100, 0, 100);
        $color = new \ImagickPixel($targetColor);
        $opacity = new \ImagickPixel(sprintf('rgb(%s, %s, %s)', $opacityPercentage, $opacityPercentage, $opacityPercentage));

        $imagick->colorizeImage($color, $opacity);

        if (array_key_exists('brightness', $this->configuration)) {
            $image->brightness((int)$this->configuration['brightness']);
        }

        if (array_key_exists('contrast', $this->configuration)) {
            $image->brightness((int)$this->configuration['contrast']);
        }
    }

    public function getRequiredConfigurationKeys(): array
    {
        return ['color'];
    }
}
