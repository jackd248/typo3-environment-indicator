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

namespace KonradMichalik\Typo3EnvironmentIndicator\Widgets;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Widget;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ViewFactoryHelper;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Dashboard\Widgets\AdditionalCssInterface;
use TYPO3\CMS\Dashboard\Widgets\ButtonProviderInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;

/**
 * EnvironmentIndicatorWidget.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class EnvironmentIndicatorWidget implements WidgetInterface, AdditionalCssInterface
{
    public function __construct(
        protected readonly WidgetConfigurationInterface $configuration,
        protected readonly ?ButtonProviderInterface $buttonProvider = null,
        protected array $options = []
    ) {}

    public function renderWidgetContent(): string
    {
        return ViewFactoryHelper::renderView(
            template: 'EnvironmentIndicatorWidget.html',
            values: [
                'configuration' => $this->configuration,
                'button' => $this->buttonProvider,
                'options' => $this->options,
                'context' => [
                    'icon' => $this->getWidgetConfiguration()['icon'] ?? 'information-application-context',
                    'name' => $this->getWidgetConfiguration()['name'] ?? Environment::getContext()->__toString(),
                    'color' => $this->getWidgetConfiguration()['color'] ?? 'transparent',
                    'textColor' => ColorUtility::getOptimalTextColor($this->getWidgetConfiguration()['color'] ?? 'transparent', fallbackColor: '#ffffff'),
                    'textSize' => $this->getWidgetConfiguration()['textSize'] ?? '20px',
                ],
            ]
        );
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getCssFiles(): array
    {
        return ['EXT:' . Configuration::EXT_KEY . '/Resources/Public/Css/Widget.css'];
    }

    private function getWidgetConfiguration(): array
    {
        return GeneralHelper::getIndicatorConfiguration()[Widget::class] ?? [];
    }
}
