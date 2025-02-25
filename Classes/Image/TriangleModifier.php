<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\Geometry\Factories\PolygonFactory;
use Intervention\Image\Interfaces\ImageInterface;

class TriangleModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $width = $image->width();
        $height = $image->height();

        $triangleSize = (int)($width * $this->configuration['size']);
        $position = $this->configuration['position'] ?? 'bottom right';

        switch ($position) {
            case 'top left':
                $points = [
                    [0, 0],
                    [$triangleSize, 0],
                    [0, $triangleSize],
                ];
                break;
            case 'top right':
                $points = [
                    [$width, 0],
                    [$width - $triangleSize, 0],
                    [$width, $triangleSize],
                ];
                break;
            case 'bottom left':
                $points = [
                    [0, $height],
                    [$triangleSize, $height],
                    [0, $height - $triangleSize],
                ];
                break;
            case 'bottom right':
            default:
                $points = [
                    [$width - $triangleSize, $height],
                    [$width, $height - $triangleSize],
                    [$width, $height],
                ];
                break;
        }

        $image->drawPolygon(function (PolygonFactory $polygon) use ($points) {
            foreach ($points as [$x, $y]) {
                $polygon->point($x, $y);
            }
            $polygon->background($this->configuration['color']);
        });
    }

    public function getRequiredConfigurationKeys(): array
    {
        return ['color'];
    }
}
