<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function count;
use function in_array;
use function is_array;
use function is_string;

/**
 * TextModifier.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
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
        $maxHeight = (int) ($image->height() / self::HEIGHT_DIVISOR);

        $configuration = $this->configuration;
        $text = $configuration['text'];
        $fontPath = GeneralUtility::getFileAbsFileName($configuration['font']);
        $position = $configuration['position'] ?? 'bottom';
        $fontSize = self::INITIAL_FONT_SIZE;

        do {
            ++$fontSize;
            $wrappedText = wordwrap($text, (int) ($maxWidth / ($fontSize * self::FONT_WIDTH_RATIO)), "\n", true);
            $lines = explode("\n", $wrappedText);
            $estimatedHeight = count($lines) * $fontSize * self::LINE_HEIGHT_MULTIPLIER;
        } while ($estimatedHeight < $maxHeight && $fontSize < self::MAX_FONT_SIZE);
        --$fontSize;

        $yPosition = ('top' === $position) ? $padding : $image->height() - $padding;

        $image->text($wrappedText, (int) ($image->width() / 2), $yPosition, function (FontFactory $font) use ($fontSize, $configuration, $fontPath, $position) {
            $font->filename($fontPath);
            $font->size($fontSize);
            $font->color($configuration['color']);
            if (isset($configuration['stroke']['color'])) {
                $font->stroke($configuration['stroke']['color'], (int) $configuration['stroke']['width']);
            }
            $font->align('center');
            $font->valign('top' === $position ? 'top' : 'bottom');
        });
    }

    public function validateConfigurationWithErrors(array $configuration): array
    {
        $errors = [];

        // Validate required text
        if (!isset($configuration['text'])) {
            $errors[] = 'Missing required configuration key: text';
        } elseif (!is_string($configuration['text'])) {
            $errors[] = 'Configuration key "text" must be a string';
        } elseif ('' === trim($configuration['text'])) {
            $errors[] = 'Configuration key "text" cannot be empty';
        }

        // Validate required color
        if (!isset($configuration['color'])) {
            $errors[] = 'Missing required configuration key: color';
        } elseif (!is_string($configuration['color'])) {
            $errors[] = 'Configuration key "color" must be a string';
        }

        // Validate optional font
        if (isset($configuration['font']) && !is_string($configuration['font'])) {
            $errors[] = 'Configuration key "font" must be a string';
        }

        // Validate optional position
        if (isset($configuration['position']) && !in_array($configuration['position'], ['top', 'bottom'], true)) {
            $errors[] = 'Configuration key "position" must be one of: top, bottom';
        }

        // Validate optional stroke configuration
        if (isset($configuration['stroke'])) {
            if (!is_array($configuration['stroke'])) {
                $errors[] = 'Configuration key "stroke" must be an array';
            } else {
                if (!isset($configuration['stroke']['color'])) {
                    $errors[] = 'Missing required stroke configuration key: color';
                } elseif (!is_string($configuration['stroke']['color'])) {
                    $errors[] = 'Stroke configuration key "color" must be a string';
                }

                if (!isset($configuration['stroke']['width'])) {
                    $errors[] = 'Missing required stroke configuration key: width';
                } elseif (!is_numeric($configuration['stroke']['width'])) {
                    $errors[] = 'Stroke configuration key "width" must be numeric';
                }
            }
        }

        return [
            'valid' => [] === $errors,
            'errors' => $errors,
        ];
    }
}
