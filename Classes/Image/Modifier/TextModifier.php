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
use Intervention\Image\Typography\FontFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TextModifier extends AbstractModifier implements ModifierInterface
{
    private const DEFAULT_PADDING = 5;
    private const TEXT_MARGIN = 4;
    private const HEIGHT_DIVISOR = 2;
    private const INITIAL_FONT_SIZE = 10;
    private const FONT_WIDTH_RATIO = 0.4;
    private const LINE_HEIGHT_MULTIPLIER = 1.2;
    private const MAX_FONT_SIZE = 50;

    public function modify(ImageInterface &$image): void
    {
        $padding = self::DEFAULT_PADDING;
        $maxWidth = $image->width() - self::TEXT_MARGIN;
        $maxHeight = (int)($image->height() / self::HEIGHT_DIVISOR);

        $configuration = $this->configuration;
        $text = $configuration['text'];
        $fontPath = GeneralUtility::getFileAbsFileName($configuration['font']);
        $position = $configuration['position'] ?? 'bottom';
        $fontSize = self::INITIAL_FONT_SIZE;

        do {
            $fontSize++;
            $wrappedText = wordwrap($text, (int)($maxWidth / ($fontSize * self::FONT_WIDTH_RATIO)), "\n", true);
            $lines = explode("\n", $wrappedText);
            $estimatedHeight = count($lines) * $fontSize * self::LINE_HEIGHT_MULTIPLIER;
        } while ($estimatedHeight < $maxHeight && $fontSize < self::MAX_FONT_SIZE);
        $fontSize--;

        $yPosition = ($position === 'top') ? $padding : $image->height() - $padding;

        $image->text($wrappedText, (int)($image->width() / 2), $yPosition, function (FontFactory $font) use ($fontSize, $configuration, $fontPath, $position) {
            $font->filename($fontPath);
            $font->size($fontSize);
            $font->color($configuration['color']);
            if (isset($configuration['stroke']['color'])) {
                $font->stroke($configuration['stroke']['color'], (int)$configuration['stroke']['width']);
            }
            $font->align('center');
            $font->valign($position === 'top' ? 'top' : 'bottom');
        });
    }

    public function validateConfiguration(array $configuration): bool
    {
        if (!isset($configuration['text']) || !is_string($configuration['text']) ||
            trim($configuration['text']) === '') {
            return false;
        }

        if (!isset($configuration['color']) || !is_string($configuration['color'])) {
            return false;
        }

        if (isset($configuration['font']) && !is_string($configuration['font'])) {
            return false;
        }

        if (isset($configuration['position']) && !in_array($configuration['position'], ['top', 'bottom'], true)) {
            return false;
        }

        if (isset($configuration['stroke'])) {
            if (!is_array($configuration['stroke'])) {
                return false;
            }
            if (!isset($configuration['stroke']['color']) || !is_string($configuration['stroke']['color'])) {
                return false;
            }
            if (!isset($configuration['stroke']['width']) || !is_numeric($configuration['stroke']['width'])) {
                return false;
            }
        }

        return true;
    }
}
