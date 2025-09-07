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

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ImageDriverUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * OverlayModifier.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class OverlayModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $manager = new ImageManager(
            ImageDriverUtility::resolveDriver()
        );
        $overlay = $manager->read(GeneralUtility::getFileAbsFileName($this->configuration['path']));

        $newWidth = (int)($image->width() * $this->configuration['size']);
        $newHeight = (int)($overlay->height() * ($newWidth / $overlay->width()));
        $overlay = $overlay->resize($newWidth, $newHeight);

        $paddingX = (int)($image->width() * $this->configuration['padding']);
        $paddingY = (int)($image->height() * $this->configuration['padding']);

        $position = str_replace(' ', '-', strtolower($this->configuration['position']));

        $image->place($overlay, $position, $paddingX, $paddingY);
    }

    public function validateConfiguration(array $configuration): bool
    {
        if (!isset($configuration['path']) || !is_string($configuration['path'])) {
            return false;
        }

        if (!isset($configuration['size']) || !is_numeric($configuration['size']) ||
            $configuration['size'] <= 0 || $configuration['size'] > 1) {
            return false;
        }

        if (!isset($configuration['position']) || !is_string($configuration['position'])) {
            return false;
        }

        $validPositions = ['top left', 'top center', 'top right', 'center left', 'center', 'center right', 'bottom left', 'bottom center', 'bottom right'];
        if (!in_array($configuration['position'], $validPositions, true)) {
            return false;
        }

        if (!isset($configuration['padding']) || !is_numeric($configuration['padding']) ||
            $configuration['padding'] < 0 || $configuration['padding'] > 1) {
            return false;
        }

        return true;
    }
}
