<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\Geometry\Factories\CircleFactory;
use Intervention\Image\Interfaces\ImageInterface;

class CircleModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $width = $image->width();
        $height = $image->height();

        $circleSize = (int)($width * $this->configuration['size']);
        $radius = (int)($circleSize / 2);

        $paddingPercent = $this->configuration['padding'];
        $paddingX = (int)($width * $paddingPercent);
        $paddingY = (int)($height * $paddingPercent);

        $x = $width - $radius - $paddingX;
        $y = $height - $radius - $paddingY;

        switch ($this->configuration['position']) {
            case 'top left':
                $x = $radius + $paddingX;
                $y = $radius + $paddingY;
                break;
            case 'top right':
                $x = $width - $radius - $paddingX;
                $y = $radius + $paddingY;
                break;
            case 'bottom left':
                $x = $radius + $paddingX;
                $y = $height - $radius - $paddingY;
                break;
            case 'bottom right':
            default:
                break;
        }

        $image->drawCircle(
            (int)$x,
            (int)$y,
            function (CircleFactory $circle) use ($radius) {
                $circle->radius($radius);
                $circle->background($this->configuration['color']);
            }
        );
    }

    public function shouldModify(): bool
    {
        return true;
    }

    public function getRequiredConfigurationKeys(): array
    {
        return ['color', 'size', 'padding', 'position'];
    }
}
