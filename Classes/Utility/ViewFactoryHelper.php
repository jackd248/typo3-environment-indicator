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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * ViewFactoryHelper.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class ViewFactoryHelper
{
    /**
    * @param array<string, mixed> $values
    */
    public static function renderView(string $template, array $values, ?ServerRequestInterface $request = null): string
    {
        $typo3Version = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();

        if ($typo3Version >= 13) {
            return self::renderView13($template, $values, $request);
        }

        return self::renderView12($template, $values);
    }

    /**
    * @param array<string, mixed> $values
    */
    private static function renderView12(string $template, array $values): string
    {
        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $view */
        $view = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class); // @phpstan-ignore classConstant.deprecatedClass
        $view->setFormat('html'); // @phpstan-ignore method.deprecatedClass
        $view->setTemplateRootPaths(['EXT:' . Configuration::EXT_KEY . '/Resources/Private/Templates/']); // @phpstan-ignore method.deprecatedClass
        $view->setPartialRootPaths(['EXT:' . Configuration::EXT_KEY . '/Resources/Private/Partials/']); // @phpstan-ignore method.deprecatedClass
        if (PathUtility::isExtensionPath($template)) {
            $template = GeneralUtility::getFileAbsFileName($template);
            $view->setTemplatePathAndFilename($template); // @phpstan-ignore method.deprecatedClass
        } else {
            $view->setTemplate($template); // @phpstan-ignore method.deprecatedClass
        }
        $view->assignMultiple($values);
        return $view->render();
    }

    /**
    * @param array<string, mixed> $values
    */
    private static function renderView13(string $template, array $values, ?ServerRequestInterface $request = null): string
    {
        $viewFactoryData = new \TYPO3\CMS\Core\View\ViewFactoryData(
            templateRootPaths: ['EXT:' . Configuration::EXT_KEY . '/Resources/Private/Templates/'],
            partialRootPaths: ['EXT:' . Configuration::EXT_KEY . '/Resources/Private/Partials/'],
            layoutRootPaths: ['EXT:' . Configuration::EXT_KEY . '/Resources/Private/Layouts/'],
            request: $request,
        );

        $viewFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\View\ViewFactoryInterface::class);
        $view = $viewFactory->create($viewFactoryData);
        $view->assignMultiple($values);

        if (PathUtility::isExtensionPath($template)) {
            $template = GeneralUtility::getFileAbsFileName($template);
        }

        return $view->render($template);
    }
}
