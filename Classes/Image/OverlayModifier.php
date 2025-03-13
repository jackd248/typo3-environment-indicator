<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ImageDriverUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class OverlayModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $manager = new ImageManager(
            ImageDriverUtility::resolveDriver()
        );
        $overlay = $manager->read(GeneralUtility::getFileAbsFileName($this->configuration['path']));

        $newWidth = (int)($image->width() * $this->configuration['size']);
        $newHeight = (int)($overlay->height() * ($newWidth / $overlay->width()));
        $overlay = $overlay->resize($newWidth, $newHeight);

        $paddingX = (int)($image->width() * $this->configuration['padding']);
        $paddingY = (int)($image->height() * $this->configuration['padding']);

        $position = str_replace(' ', '-', strtolower($this->configuration['position']));

        $image->place($overlay, $position, $paddingX, $paddingY);
    }

    public function getRequiredConfigurationKeys(): array
    {
        return ['path', 'size', 'position', 'padding'];
    }
}
