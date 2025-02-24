<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\Interfaces\ImageInterface;

interface ModifierInterface
{
    public function modify(ImageInterface &$image): void;

    public function shouldModify(): bool;

    public function getRequiredConfigurationKeys(): array;
}
