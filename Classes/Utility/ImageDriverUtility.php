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

use Intervention\Image\Interfaces\DriverInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * ImageDriverUtility.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class ImageDriverUtility
{
    public const IMAGE_DRIVER_GD = 'gd';
    public const IMAGE_DRIVER_IMAGICK = 'imagick';
    public const IMAGE_DRIVER_VIPS = 'vips';

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
