<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier;

use Intervention\Image\Interfaces\ImageInterface;

interface ModifierInterface
{
    public function modify(ImageInterface &$image): void;

    public function getRequiredConfigurationKeys(): array;
}
