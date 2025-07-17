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

    public function getRequiredConfigurationKeys(): array
    {
        return ['path', 'size', 'position', 'padding'];
    }
}
