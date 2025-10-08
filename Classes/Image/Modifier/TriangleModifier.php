<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier;

use Intervention\Image\Geometry\Factories\PolygonFactory;
use Intervention\Image\Interfaces\ImageInterface;

use function in_array;
use function is_string;

/**
 * TriangleModifier.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class TriangleModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $width = $image->width();
        $height = $image->height();

        $triangleSize = (int) ($width * $this->configuration['size']);
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

    public function validateConfiguration(array $configuration): bool
    {
        if (!isset($configuration['color']) || !is_string($configuration['color'])) {
            return false;
        }

        if (isset($configuration['size'])
            && (!is_numeric($configuration['size']) || $configuration['size'] < 0 || $configuration['size'] > 1)) {
            return false;
        }

        if (isset($configuration['position']) && !is_string($configuration['position'])) {
            return false;
        }

        $validPositions = ['top left', 'top right', 'bottom left', 'bottom right'];

        return !(isset($configuration['position']) && !in_array($configuration['position'], $validPositions, true));
    }
}
