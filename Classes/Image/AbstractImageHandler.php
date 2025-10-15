<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\{GeneralHelper, ImageDriverUtility};
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\{GeneralUtility, PathUtility};

use function is_string;

/**
 * AbstractImageHandler.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
abstract class AbstractImageHandler
{
    public function __construct(protected IndicatorInterface $indicator) {}

    public function process(string $path, ServerRequestInterface $request): string
    {
        if (!$this->shouldProcessImage($path)) {
            return $path;
        }

        $newImageFilename = $this->generateFilename($path, $request).'.png';
        $newImagePath = GeneralHelper::getFolder($this->indicator, false).$newImageFilename;

        if ($path === $newImagePath) {
            return $newImagePath;
        }

        $absoluteNewImagePath = GeneralHelper::getFolder($this->indicator).$newImageFilename;
        if (file_exists($absoluteNewImagePath)) {
            return $newImagePath;
        }

        if (!$this->processAndSaveImage($path, $newImageFilename, $request)) {
            return $path;
        }

        return $newImagePath;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getImageModifiers(ServerRequestInterface $request): array
    {
        return GeneralHelper::getIndicatorConfiguration()[$this->indicator::class] ?? [];
    }

    protected function generateFilename(string $originalPath, ServerRequestInterface $request): string
    {
        $parts = [
            $originalPath,
            Environment::getContext()->__toString(),
        ];
        foreach ($this->getImageModifiers($request) as $modifier => $configuration) {
            $parts[] = $modifier;
            $parts[] = json_encode($configuration);
        }

        return hash('sha256', implode('_', $parts));
    }

    protected function convertIcoToPng(string &$path, string $filename): void
    {
        $loader = new \Elphin\IcoFileLoader\IcoFileService();
        $icoImage = $loader->fromFile($path);

        foreach ($icoImage as $idx => $image) {
            $tmp = $loader->renderImage($image);

            $basePath = Environment::getPublicPath().'/'.GeneralHelper::getFolder($this->indicator, false).'processed/';
            if (!file_exists($basePath)) {
                GeneralUtility::mkdir_deep($basePath);
            }

            $path = $basePath.$idx.'--'.$filename;

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

        $basePath = Environment::getPublicPath().'/'.GeneralHelper::getFolder($this->indicator, false).'processed/';
        if (!file_exists($basePath)) {
            GeneralUtility::mkdir_deep($basePath);
        }

        $path = $basePath.'--'.$filename;

        if (file_exists($path)) {
            return;
        }

        $rasterImage = $svgImage->toRasterImage((int) $svgImage->getDocument()->getWidth(), (int) $svgImage->getDocument()->getHeight());
        imagepng($rasterImage, $path); // @phpstan-ignore-line
    }

    private function shouldProcessImage(string $path): bool
    {
        $absolutePath = GeneralUtility::getFileAbsFileName($path);

        if (!file_exists($absolutePath)) {
            return false;
        }

        if (!GeneralHelper::isCurrentIndicator($this->indicator::class)) {
            return false;
        }

        return true;
    }

    private function processAndSaveImage(string $path, string $newImageFilename, ServerRequestInterface $request): bool
    {
        $manager = new ImageManager(ImageDriverUtility::resolveDriver());
        $absolutePath = PathUtility::isAbsolutePath($path) ? $path : GeneralUtility::getFileAbsFileName($path);

        $format = pathinfo($absolutePath, \PATHINFO_EXTENSION);
        if (!GeneralHelper::supportFormat($manager, $format)) {
            return false;
        }

        $this->preProcessImage($absolutePath, $newImageFilename, $format);

        $image = $manager->read($absolutePath);
        $this->applyImageModifiers($image, $request);
        $image->save(GeneralHelper::getFolder($this->indicator).$newImageFilename);

        return true;
    }

    private function applyImageModifiers(ImageInterface $image, ServerRequestInterface $request): void
    {
        foreach ($this->getImageModifiers($request) as $key => $modifier) {
            /* @phpstan-ignore function.alreadyNarrowedType */
            if (is_string($key) && str_starts_with($key, '_')) {
                continue;
            }

            if (!method_exists($modifier, 'modify')) {
                continue;
            }

            $modifier->modify($image);
        }
    }

    private function preProcessImage(string &$absolutePath, string &$newImageFilename, string $format): void
    {
        /*
        * GD driver does not support .ico files, so we need to convert them to .png before processing them
        */
        if (ImageDriverUtility::IMAGE_DRIVER_GD === ImageDriverUtility::getImageDriverConfiguration() && 'ico' === $format) {
            $this->convertIcoToPng($absolutePath, $newImageFilename);
        }

        if ('svg' === $format) {
            $this->convertSvgToPng($absolutePath, $newImageFilename);
        }
    }
}
