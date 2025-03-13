<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use ImagickPixel;
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
        $color = new ImagickPixel($targetColor);
        $opacity = new ImagickPixel(sprintf('rgb(%s, %s, %s)', $opacityPercentage, $opacityPercentage, $opacityPercentage));

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
