<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use Intervention\Image\Interfaces\DriverInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ImageDriverUtility
{
    const IMAGE_DRIVER_GD = 'gd';
    const IMAGE_DRIVER_IMAGICK = 'imagick';
    const IMAGE_DRIVER_VIPS = 'vips';

    public static function getImageDriverConfiguration(): string
    {
        return GeneralUtility::makeInstance(ExtensionConfiguration::class)->get(Configuration::EXT_KEY)['general']['imageDriver'] ?? self::IMAGE_DRIVER_GD;
    }

    public static function resolveDriver(): DriverInterface
    {
        switch (self::getImageDriverConfiguration()) {
            case self::IMAGE_DRIVER_IMAGICK:
                return new \Intervention\Image\Drivers\Imagick\Driver();
            case self::IMAGE_DRIVER_VIPS:
                if (!class_exists('\\Intervention\\Image\\Drivers\\Vips\\Driver')) {
                    throw new \RuntimeException('Vips intervention image driver not available, you need intervention/image-driver-vips', 1741785476);
                }
                return new \Intervention\Image\Drivers\Vips\Driver(); // @phpstan-ignore-line
            case self::IMAGE_DRIVER_GD:
            default:
                return new \Intervention\Image\Drivers\Gd\Driver();
        }
    }
}
