<?php

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

namespace KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Topbar;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ViewFactoryHelper;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * TopbarItem.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class TopbarItem implements ToolbarItemInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {}

    public function checkAccess(): bool
    {
        return true;
    }

    public function getItem(): string
    {
        $extensionConfig = $this->extensionConfiguration->get(Configuration::EXT_KEY);
        if ((bool)($extensionConfig['backend']['context'] ?? false) !== true ||
            !GeneralHelper::isCurrentIndicator(Topbar::class)) {
            return '';
        }

        if ((bool)($extensionConfig['backend']['contextProduction'] ?? false) !== true && Environment::getContext()->__toString() === 'Production') {
            return '';
        }

        $color = $this->getBackendTopbarConfiguration()['color'] ?? [];

        if ($color === []) {
            return '';
        }

        $backendCssPath =  Environment::getPublicPath() . '/typo3temp/assets/css/' . Configuration::EXT_KEY . '/';
        if (!file_exists($backendCssPath)) {
            GeneralUtility::mkdir_deep($backendCssPath);
        }

        $removeTransition = $this->getBackendTopbarConfiguration()['removeTransition'] ?? false;
        $backendCssFile = sprintf(
            '%sbackend-%s.css',
            $backendCssPath,
            hash('sha256', implode('_', [Environment::getContext()->__toString(), $color, $removeTransition]))
        );

        if (!file_exists($backendCssFile)) {
            $textColor = ColorUtility::getOptimalTextColor($color);
            $subTextColor = ColorUtility::getOptimalTextColor($color, 0.8);

            $fileContent = ViewFactoryHelper::renderView(
                template: 'ToolbarItems/TopbarItem.html',
                values: [
                    'color' => $color,
                    'textColor' => $textColor,
                    'subTextColor' => $subTextColor,
                    'removeTransition' => $removeTransition,
                ]
            );

            GeneralUtility::writeFile($backendCssFile, $fileContent);
        }

        /** @var PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile($backendCssFile);

        return '';
    }

    public function hasDropDown(): bool
    {
        return false;
    }

    public function getDropDown(): string
    {
        return '';
    }

    public function getAdditionalAttributes(): array
    {
        return [];
    }

    public function getIndex(): int
    {
        return 0;
    }

    private function getBackendTopbarConfiguration(): array
    {
        return GeneralHelper::getIndicatorConfiguration()[Topbar::class] ?? [];
    }
}
