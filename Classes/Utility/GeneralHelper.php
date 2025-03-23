<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use Intervention\Image\Interfaces\ImageManagerInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
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

    public static function generateTopbarBackendCss(bool $removeTransition = false): void
    {
        $color = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backendTopbar']['color'] ?? [];

        if (empty($color)) {
            return;
        }

        $backendCssPath =  Environment::getPublicPath() . '/typo3temp/assets/css/' . Configuration::EXT_KEY . '/';
        if (!file_exists($backendCssPath)) {
            GeneralUtility::mkdir_deep($backendCssPath);
        }
        $backendCssFile = sprintf(
            '%sbackend-%s.css',
            $backendCssPath,
            md5(Environment::getContext()->__toString())
        );

        $textColor = ColorUtility::getOptimalTextColor($color);
        $subTextColor = ColorUtility::getOptimalTextColor($color, 0.8);

        $additionalCss = '';
        if ($removeTransition) {
            $additionalCss = ' .topbar [class$="-header-site"]::before, .topbar [class$="-header-site"]::after { display:none; } #konradmichalik-typo3environmentindicator-backend-toolbaritems-contextitem { margin-left:0; }';
        }

        $fileContent = sprintf(
            '.topbar > div { background-color: %s; color: %s; } .topbar [class$="-site-version"] { color: %s; } .topbar-site { padding-left: 1em; } %s',
            $color,
            $textColor,
            $subTextColor,
            $additionalCss
        );
        GeneralUtility::writeFile($backendCssFile, $fileContent);

        /** @var PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile($backendCssFile);
    }
}
