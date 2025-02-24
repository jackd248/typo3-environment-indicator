<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use TYPO3\CMS\Core\Core\Environment;

class GeneralHelper
{
    public static function getFaviconConfiguration(string $key): string|bool
    {
        foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'] as $context => $extension) {
            if ($context === Environment::getContext()->__toString()) {
                return $extension['favicon'][$key];
            }
        }
        return false;
    }

    public static function getFaviconFolder(bool $publicPath = true): string
    {
        $defaultPath = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['global']['favicon']['path'];

        $path = Environment::getPublicPath() . '/' . $defaultPath;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if (!$publicPath) {
            return $defaultPath;
        }
        return $path;
    }
}
