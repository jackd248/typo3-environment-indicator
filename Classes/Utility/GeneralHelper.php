<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use Intervention\Image\Interfaces\ImageManagerInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
