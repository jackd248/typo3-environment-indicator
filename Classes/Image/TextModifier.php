<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TextModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $padding = 5;
        $maxWidth = $image->width() - 4;
        $maxHeight = $image->height() / 2;

        $configuration = $this->configuration;
        $text = $configuration['text'];
        $fontPath = GeneralUtility::getFileAbsFileName($configuration['font']);
        $fontSize = 10;

        do {
            $fontSize++;
            $wrappedText = wordwrap($text, (int)($maxWidth / ($fontSize * 0.4)), "\n", true);
            $lines = explode("\n", $wrappedText);
            $estimatedHeight = count($lines) * $fontSize * 1.2;
        } while ($estimatedHeight < $maxHeight && $fontSize < 50);
        $fontSize--;

        $image->text($wrappedText, $image->width() / 2, $image->height() - $padding, function (FontFactory $font) use ($fontSize, $configuration, $fontPath) {
            $font->filename($fontPath);
            $font->size($fontSize);
            $font->color($configuration['color']);
            if (isset($configuration['stroke']['color'])) {
                $font->stroke($configuration['stroke']['color'], (int)$configuration['stroke']['width']);
            }
            $font->align('center');
            $font->valign('bottom');
        });
    }

    public function getRequiredConfigurationKeys(): array
    {
        return ['text', 'color'];
    }
}
