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

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use Intervention\Image\ImageManager;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ImageDriverUtility;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * AbstractImageHandler.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
abstract class AbstractImageHandler
{
    public function __construct(protected IndicatorInterface $indicator) {}

    public function process(string $path, ServerRequestInterface $request): string
    {
        $absolutePath = GeneralUtility::getFileAbsFileName($path);

        if (!file_exists($absolutePath)) {
            return $path;
        }

        if (!GeneralHelper::isCurrentIndicator($this->indicator::class)) {
            return $path;
        }

        $newImageFilename = $this->generateFilename($path, $request) . '.png';
        $newImagePath = GeneralHelper::getFolder($this->indicator, false) . $newImageFilename;

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

        foreach ($this->getImageModifiers($request) as $key => $modifier) {
            if (is_string($key) && str_starts_with($key, '_')) {
                continue;
            }

            if (!method_exists($modifier, 'modify')) {
                continue;
            }

            $modifier->modify($image);
        }

        $image->save(GeneralHelper::getFolder($this->indicator) . $newImageFilename);
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

            $basePath = Environment::getPublicPath() . '/' . GeneralHelper::getFolder($this->indicator, false) . 'processed/';
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

        $basePath = Environment::getPublicPath() . '/' . GeneralHelper::getFolder($this->indicator, false) . 'processed/';
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
