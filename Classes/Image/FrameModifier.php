<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\Interfaces\ImageInterface;

class FrameModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $width = $image->width();
        $height = $image->height();

        $borderSize = $this->configuration['borderSize'] ?? 5;
        $borderColor = $this->configuration['color'] ?? 'black';

        $image->drawRectangle(0, 0, function (RectangleFactory $rectangle) use ($width, $height, $borderSize, $borderColor) {
            $rectangle->size($width, $height);
            $rectangle->border($borderColor, $borderSize);
        });
    }

    public function getRequiredConfigurationKeys(): array
    {
        return ['color'];
    }
}
