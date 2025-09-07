<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "typo3_environment_indicator".
 *
 * Copyright (C) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

/**
 * ColorUtility.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class ColorUtility
{
    public static function getColoredString(?string $name = null): string
    {
        $name = $name ?? (string)$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];
        $hash = hash('sha256', $name);
        $hue = hexdec(substr($hash, 0, 2)) / 255 * 360;
        return sprintf('hsl(%d, 70%%, 60%%)', $hue);
    }

    public static function getOptimalTextColor(string $color, float $opacity = 1, array|string $fallbackColor = [0, 0, 0]): string
    {
        $rgb = self::colorToRgb($color, $fallbackColor);
        return self::calculateLuminance($rgb[0], $rgb[1], $rgb[2]) > 0.5 ? "rgba(0,0,0,$opacity)" : "rgba(255,255,255,$opacity)";
    }

    public static function colorToRgb(string $color, array|string $fallbackColor = [0, 0, 0]): array
    {
        if (preg_match('/^#([a-fA-F0-9]{3,6})$/', $color, $matches)) {
            return self::hexToRgb($color);
        }
        if (preg_match('/rgb\((\d+),\s*(\d+),\s*(\d+)\)/', $color, $matches)) {
            return [(int)$matches[1], (int)$matches[2], (int)$matches[3]];
        }
        if (preg_match('/hsl\((\d+),\s*(\d+)%?,\s*(\d+)%?\)/', $color, $matches)) {
            return self::hslToRgb((int)$matches[1], (int)$matches[2], (int)$matches[3]);
        }

        if (is_string($fallbackColor)) {
            $fallbackColor = self::colorToRgb($fallbackColor);
        }
        return $fallbackColor;
    }

    public static function hexToRgb(string $hex): array
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
