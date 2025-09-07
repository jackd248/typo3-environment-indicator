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

use Intervention\Image\Interfaces\ImageManagerInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * GeneralHelper.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class GeneralHelper
{
    public static function getFolder(IndicatorInterface $indicator, bool $publicPath = true): string
    {
        $defaultPath = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'][$indicator::class]['_path'];

        $path = Environment::getPublicPath() . '/' . $defaultPath;
        if (!file_exists($path)) {
            GeneralUtility::mkdir_deep($path);
        }

        if (!$publicPath) {
            return $defaultPath;
        }
        return $path;
    }

    public static function getIndicatorConfiguration(): array
    {
        return Handler::resolveIndicators();
    }

    public static function isCurrentIndicator(string $indicatorClass): bool
    {
        return array_key_exists(
            $indicatorClass,
            GeneralHelper::getIndicatorConfiguration()
        );
    }

    public static function supportFormat(ImageManagerInterface $manager, string $format): bool
    {
        return ($format === 'ico') || ($format === 'svg') || $manager->driver()->supports($format);
    }
}
