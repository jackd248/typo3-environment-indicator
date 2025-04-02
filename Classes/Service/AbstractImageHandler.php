<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use Intervention\Image\ImageManager;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Enum\HandlerType;
use KonradMichalik\Typo3EnvironmentIndicator\Enum\Scope;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ImageDriverUtility;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

abstract class AbstractImageHandler
{
    public function __construct(protected Scope $scope, protected HandlerType $type)
    {
    }

    abstract protected function getEnvironmentImageModifiers(ServerRequestInterface $request): array;

    public function process(string $path, ServerRequestInterface $request): string
    {
        $absolutePath = GeneralUtility::getFileAbsFileName($path);

        if (!file_exists($absolutePath)) {
            return $path;
        }

        if (!array_key_exists(Environment::getContext()->__toString(), $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'])
            || !array_key_exists($this->scope->value, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()])
            || !array_key_exists($this->type->value, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()][$this->scope->value])) {
            return $path;
        }

        $newImageFilename = $this->generateFilename($path, $request) . '.png';
        $newImagePath = GeneralHelper::getFolder($this->type, false) . $newImageFilename;

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

        $this->preProcessImage($absolutePath, $newImageFilename, $format);

        $image = $manager->read($absolutePath);

        foreach ($this->getEnvironmentImageModifiers($request) as $modifier => $configuration) {
            $modifierInstance = ImageModifyManager::makeInstance($modifier, $configuration);
            $modifierInstance->modify($image);
        }

        $image->save(GeneralHelper::getFolder($this->type) . $newImageFilename);
        return $newImagePath;
    }

    private function preProcessImage(string &$absolutePath, string &$newImageFilename, string $format): void
    {
        /*
        * GD driver does not support .ico files, so we need to convert them to .png before processing them
        */
        if (ImageDriverUtility::getImageDriverConfiguration() === ImageDriverUtility::IMAGE_DRIVER_GD && $format === 'ico') {
            $this->convertIcoToPng($absolutePath, $newImageFilename);
        }

        if ($format === 'svg') {
            $this->convertSvgToPng($absolutePath, $newImageFilename);
        }
    }

    /*
    * Can't use array_replace_recursive here, cause it keeps the order of the first array, not of the second overwriting array
    */
    protected function mergeConfigurationRecursiveOrdered(array $array1, array $array2): array
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

    protected function generateFilename(string $originalPath, ServerRequestInterface $request): string
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

    protected function convertIcoToPng(string &$path, string $filename): void
    {
        $loader = new \Elphin\IcoFileLoader\IcoFileService();
        $icoImage = $loader->fromFile($path);

        foreach ($icoImage as $idx => $image) {
            $tmp = $loader->renderImage($image);

            $basePath = Environment::getPublicPath() . '/' . GeneralHelper::getFolder(HandlerType::Image, false) . 'processed/';
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

    /*
    * @see https://github.com/meyfa/php-svg?tab=readme-ov-file#rasterizing
    * Notes from the author:
    * This feature in particular is very much work-in-progress. Many things will look wrong and rendering large images may be very slow.
    */
    protected function convertSvgToPng(string &$path, string $filename): void
    {
        $loader = new \SVG\SVG();
        $svgImage = $loader::fromFile($path);

        $basePath = Environment::getPublicPath() . '/' . GeneralHelper::getFolder(HandlerType::Image, false) . 'processed/';
        if (!file_exists($basePath)) {
            GeneralUtility::mkdir_deep($basePath);
        }

        $path = $basePath . '--' . $filename;

        if (file_exists($path)) {
            return;
        }

        $rasterImage = $svgImage->toRasterImage((int)$svgImage->getDocument()->getWidth(), (int)$svgImage->getDocument()->getHeight());
        imagepng($rasterImage, $path); // @phpstan-ignore-line
    }
}
