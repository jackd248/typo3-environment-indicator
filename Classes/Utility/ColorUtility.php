<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

class ColorUtility
{
    public static function getSitenameColor(): string
    {
        $hash = md5((string)$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']);
        $hue = hexdec(substr($hash, 0, 2)) / 255 * 360;
        return sprintf('hsl(%d, 70%%, 60%%)', $hue);
    }
}
