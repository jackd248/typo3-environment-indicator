<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

class ColorUtility
{
    public static function getColoredString(?string $name = null): string
    {
        $name = $name ?? (string)$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];
        $hash = md5($name);
        $hue = hexdec(substr($hash, 0, 2)) / 255 * 360;
        return sprintf('hsl(%d, 70%%, 60%%)', $hue);
    }
}
