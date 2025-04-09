<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Widgets;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Widget;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Dashboard\Widgets\AdditionalCssInterface;
use TYPO3\CMS\Dashboard\Widgets\ButtonProviderInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class EnvironmentIndicatorWidget implements WidgetInterface, AdditionalCssInterface
{
    public function __construct(
        protected readonly WidgetConfigurationInterface $configuration,
        protected readonly ?ButtonProviderInterface $buttonProvider = null,
        protected array $options = []
    ) {
    }

    public function renderWidgetContent(): string
    {
        $template = GeneralUtility::getFileAbsFileName('EXT:' . Configuration::EXT_KEY . '/Resources/Private/Templates/EnvironmentIndicatorWidget.html');

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setFormat('html');
        $view->setTemplatePathAndFilename($template);

        $view->assignMultiple([
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
        ]);
        return $view->render();
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
