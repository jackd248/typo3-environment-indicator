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
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Toolbar;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ViewFactoryHelper;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;

class ContextItem implements ToolbarItemInterface
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
        if (($extensionConfig['backend']['context'] ?? false) !== true ||
            !GeneralHelper::isCurrentIndicator(Toolbar::class)) {
            return '';
        }

        $extensionConfig = $this->extensionConfiguration->get(Configuration::EXT_KEY);
        if (($extensionConfig['backend']['contextProduction'] ?? false) !== true && Environment::getContext()->__toString() === 'Production') {
            return '';
        }

        $toolbarConfig = $this->getBackendToolbarConfiguration();
        if ($toolbarConfig === []) {
            return '';
        }

        return ViewFactoryHelper::renderView(
            template: 'ToolbarItems/ContextItem.html',
            values: [
                'context' => [
                    'icon' => $this->getBackendToolbarConfiguration()['icon']['context'] ?? 'information-application-context',
                    'name' => $this->getBackendToolbarConfiguration()['name'] ?? Environment::getContext()->__toString(),
                    'color' => $this->getBackendToolbarConfiguration()['color'] ?? 'transparent',
                    'textColor' => ColorUtility::getOptimalTextColor($this->getBackendToolbarConfiguration()['color'] ?? 'transparent'),
                ],
            ]
        );
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
        $toolbarConfig = $this->getBackendToolbarConfiguration();
        return $toolbarConfig !== [] ? $toolbarConfig['index'] : 0;
    }

    private function getBackendToolbarConfiguration(): array
    {
        return GeneralHelper::getIndicatorConfiguration()[Toolbar::class] ?? [];
    }
}
