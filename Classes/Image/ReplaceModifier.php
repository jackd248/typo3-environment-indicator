<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ReplaceModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $manager = new ImageManager(
            new Driver()
        );
        $image = $manager->read(GeneralUtility::getFileAbsFileName($this->configuration['path']));
    }

    public function getRequiredConfigurationKeys(): array
    {
        return ['path'];
    }
}
