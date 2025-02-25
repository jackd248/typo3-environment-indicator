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

    public static function getOptimalTextColor(string $color): string
    {
        if (preg_match('/^#([a-fA-F0-9]{3,6})$/', $color, $matches)) {
            $rgb = self::hexToRgb($color);
        } elseif (preg_match('/rgb\((\d+),\s*(\d+),\s*(\d+)\)/', $color, $matches)) {
            $rgb = [(int)$matches[1], (int)$matches[2], (int)$matches[3]];
        } elseif (preg_match('/hsl\((\d+),\s*(\d+)%?,\s*(\d+)%?\)/', $color, $matches)) {
            $rgb = self::hslToRgb((int)$matches[1], (int)$matches[2], (int)$matches[3]);
        } else {
            return '#000000';
        }

        return self::calculateLuminance($rgb[0], $rgb[1], $rgb[2]) > 0.5 ? '#000000' : '#FFFFFF';
    }

    public static function hexToRgb($hex): array
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = "{$hex[0]}{$hex[0]}{$hex[1]}{$hex[1]}{$hex[2]}{$hex[2]}";
        }
        return [hexdec($hex[0] . $hex[1]), hexdec($hex[2] . $hex[3]), hexdec($hex[4] . $hex[5])];
    }

    public static function hslToRgb(int $h, int $s, int $l): array
    {
        $s /= 100;
        $l /= 100;
        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60.0, 2) - 1));
        $m = $l - $c / 2;

        if ($h < 60) {
            [$r, $g, $b] = [$c, $x, 0];
        } elseif ($h < 120) {
            [$r, $g, $b] = [$x, $c, 0];
        } elseif ($h < 180) {
            [$r, $g, $b] = [0, $c, $x];
        } elseif ($h < 240) {
            [$r, $g, $b] = [0, $x, $c];
        } elseif ($h < 300) {
            [$r, $g, $b] = [$x, 0, $c];
        } else {
            [$r, $g, $b] = [$c, 0, $x];
        }

        return [round(($r + $m) * 255), round(($g + $m) * 255), round(($b + $m) * 255)];
    }

    public static function calculateLuminance(int $r, int $g, int $b): float
    {
        return 0.2126 * ($r / 255) + 0.7152 * ($g / 255) + 0.0722 * ($b / 255);
    }
}
