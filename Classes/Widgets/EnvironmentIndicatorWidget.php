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

namespace KonradMichalik\Typo3EnvironmentIndicator\Widgets;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Widget;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\{ColorUtility, GeneralHelper, ViewFactoryHelper};
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Dashboard\Widgets\{AdditionalCssInterface, ButtonProviderInterface, WidgetConfigurationInterface, WidgetInterface};

/**
 * EnvironmentIndicatorWidget.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
class EnvironmentIndicatorWidget implements WidgetInterface, AdditionalCssInterface
{
    /**
     * @param array<string, mixed> $options
     */
    public function __construct(
        protected readonly WidgetConfigurationInterface $configuration,
        protected readonly ?ButtonProviderInterface $buttonProvider = null,
        protected array $options = [],
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
            ],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return array<int, string>
     */
    public function getCssFiles(): array
    {
        return ['EXT:'.Configuration::EXT_KEY.'/Resources/Public/Css/Widget.css'];
    }

    /**
     * @return array<string, mixed>
     */
    private function getWidgetConfiguration(): array
    {
        return GeneralHelper::getIndicatorConfiguration()[Widget::class] ?? [];
    }
}
