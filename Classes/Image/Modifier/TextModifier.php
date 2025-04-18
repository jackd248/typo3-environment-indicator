<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TextModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $padding = 5;
        $maxWidth = (int)$image->width() - 4;
        $maxHeight = (int)($image->height() / 2);

        $configuration = $this->configuration;
        $text = $configuration['text'];
        $fontPath = GeneralUtility::getFileAbsFileName($configuration['font']);
        $position = $configuration['position'] ?? 'bottom';
        $fontSize = 10;

        do {
            $fontSize++;
            $wrappedText = wordwrap($text, (int)($maxWidth / ($fontSize * 0.4)), "\n", true);
            $lines = explode("\n", $wrappedText);
            $estimatedHeight = count($lines) * $fontSize * 1.2;
        } while ($estimatedHeight < $maxHeight && $fontSize < 50);
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

    public function getRequiredConfigurationKeys(): array
    {
        return ['text', 'color'];
    }
}
