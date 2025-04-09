<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ImageDriverUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ReplaceModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $manager = new ImageManager(
            ImageDriverUtility::resolveDriver()
        );
        $image = $manager->read(GeneralUtility::getFileAbsFileName($this->configuration['path']));
    }

    public function getRequiredConfigurationKeys(): array
    {
        return ['path'];
    }
}
