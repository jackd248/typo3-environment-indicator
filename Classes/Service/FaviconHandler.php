<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use Intervention\Image\ImageManager;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ImageDriverUtility;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use ValueError;

class FaviconHandler
{
    public function process(string $path, ServerRequestInterface $request): string
    {
        $absolutePath = GeneralUtility::getFileAbsFileName($path);
        if (!file_exists($absolutePath)) {
            return $path;
        }

        if (!in_array(Environment::getContext()->__toString(), array_keys($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context']))
            || array_key_exists('favicon', $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]) === false) {
            return $path;
        }

        $newImageFilename = $this->generateFilename($path, $request) . '.png';
        $newImagePath = GeneralHelper::getFaviconFolder(false) . $newImageFilename;

        if ($path === $newImagePath) {
            return $newImagePath;
        }

        $manager = new ImageManager(
            ImageDriverUtility::resolveDriver()
        );
        $absolutePath = PathUtility::isAbsolutePath($path) ? $path : GeneralUtility::getFileAbsFileName($path);

        $format = pathinfo($absolutePath, PATHINFO_EXTENSION);
        if (!GeneralHelper::supportFormat($manager, $format)) {
            return $path;
        }

        /*
        * GD driver does not support .ico files, so we need to convert them to .png before processing them
        */
        if (ImageDriverUtility::getImageDriverConfiguration() === ImageDriverUtility::IMAGE_DRIVER_GD && pathinfo($absolutePath, PATHINFO_EXTENSION) === 'ico') {
            $this->convertIcoToPng($absolutePath, $newImageFilename);
        }

        try {
            $image = $manager->read($absolutePath);
        } catch (ValueError $e) { // @phpstan-ignore-line
            if ($e->getMessage() === '"image/vnd.microsoft.icon" is not a valid backing value for enum Intervention\Image\MediaType') {
                throw new ValueError(sprintf('.ico files are not supported by "%s" image driver: %s', ImageDriverUtility::getImageDriverConfiguration(), $absolutePath), 1741786477);
            }
            throw $e;
        }

        foreach ($this->getEnvironmentImageModifiers($request) as $modifier => $configuration) {
            $modifierInstance = ImageModifyManager::makeInstance($modifier, $configuration);
            $modifierInstance->modify($image);
        }

        $image->save(GeneralHelper::getFaviconFolder() . $newImageFilename);
        return $newImagePath;
    }

    private function getEnvironmentImageModifiers(ServerRequestInterface $request): array
    {
        $configuration = isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']['*']) ?
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']['*'] : [];
        if (ApplicationType::fromRequest($request)->isFrontend()) {
            $configuration = $this->mergeConfigurationRecursiveOrdered($configuration, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']['frontend'] ?? []);
        } elseif (ApplicationType::fromRequest($request)->isBackend()) {
            $configuration = $this->mergeConfigurationRecursiveOrdered($configuration, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']['backend'] ?? []);
        }
        return $configuration;
    }

    /*
    * Can't use array_replace_recursive here, cause it keeps the order of the first array, not of the second overwriting array
    */
    private function mergeConfigurationRecursiveOrdered(array $array1, array $array2): array
    {
        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($array1[$key]) && is_array($array1[$key])) {
                $array1[$key] = $this->mergeConfigurationRecursiveOrdered($array1[$key], $value);
            } else {
                $array1[$key] = $value;
            }
        }
        return $array1;
    }

    private function generateFilename(string $originalPath, ServerRequestInterface $request): string
    {
        $parts = [
            $originalPath,
            Environment::getContext()->__toString(),
        ];
        foreach ($this->getEnvironmentImageModifiers($request) as $modifier => $configuration) {
            $parts[] = $modifier;
            $parts[] = json_encode($configuration);
        }
        return md5(implode('_', $parts));
    }

    private function convertIcoToPng(string &$path, string $filename): void
    {
        $loader = new \Elphin\IcoFileLoader\IcoFileService();
        $icon = $loader->fromFile($path);

        foreach ($icon as $idx => $image) {
            $tmp = $loader->renderImage($image);

            $basePath = Environment::getPublicPath() . '/' . GeneralHelper::getFaviconFolder(false) . 'convert/';
            if (!file_exists($basePath)) {
                GeneralUtility::mkdir_deep($basePath);
            }

            $path = $basePath . $idx . '--' . $filename;

            if (file_exists($path)) {
                continue;
            }
            imagepng($tmp, $path);
        }
    }
}
