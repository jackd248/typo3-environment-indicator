<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use Intervention\Image\Interfaces\ImageManagerInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GeneralHelper
{
    public static function getFaviconFolder(bool $publicPath = true): string
    {
        $defaultPath = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['global']['favicon']['path'];

        $path = Environment::getPublicPath() . '/' . $defaultPath;
        if (!file_exists($path)) {
            GeneralUtility::mkdir_deep($path);
        }

        if (!$publicPath) {
            return $defaultPath;
        }
        return $path;
    }

    public static function getGlobalConfiguration(): array
    {
        return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['global'];
    }

    public static function supportFormat(ImageManagerInterface $manager, string $format): bool
    {
        return ($format === 'ico') || $manager->driver()->supports($format);
    }
}
