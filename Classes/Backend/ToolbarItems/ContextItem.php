<?php

namespace KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Toolbar;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ContextItem implements ToolbarItemInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {
    }

    public function checkAccess(): bool
    {
        return true;
    }

    public function getItem(): string
    {
        if (!$this->extensionConfiguration->get(Configuration::EXT_KEY)['backend']['context'] ||
            ! GeneralHelper::isCurrentIndicator(Toolbar::class)) {
            return '';
        }

        if (!$this->extensionConfiguration->get(Configuration::EXT_KEY)['backend']['contextProduction'] && Environment::getContext()->__toString() === 'Production') {
            return '';
        }

        if (empty($this->getBackendToolbarConfiguration())) {
            return '';
        }

        /*
        * ToDo: StandaloneView is deprecated in v13
        */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:' . Configuration::EXT_KEY
            . '/Resources/Private/Templates/ToolbarItems/ContextItem.html'));
        return $view->assignMultiple([
            'context' => [
                'icon' => $this->getBackendToolbarConfiguration()['icon']['context'] ?? 'information-application-context',
                'name' => $this->getBackendToolbarConfiguration()['name'] ?? Environment::getContext()->__toString(),
                'color' => $this->getBackendToolbarConfiguration()['color'] ?? 'transparent',
                'textColor' => ColorUtility::getOptimalTextColor($this->getBackendToolbarConfiguration()['color'] ?? 'transparent'),
            ],
        ])->render();
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
        return !empty($this->getBackendToolbarConfiguration()) ? $this->getBackendToolbarConfiguration()['index'] : 0;
    }

    private function getBackendToolbarConfiguration(): array
    {
        return GeneralHelper::getIndicatorConfiguration()[Toolbar::class] ?? [];
    }
}
