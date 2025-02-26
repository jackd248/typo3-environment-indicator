<?php

namespace KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ProjectStatusItem implements ToolbarItemInterface
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
        if (!$this->extensionConfiguration->get(Configuration::EXT_KEY)['backend']['context']) {
            return '';
        }

        /*
        * ToDo: StandaloneView is deprecated in v13
        */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:' . Configuration::EXT_KEY
            . '/Resources/Private/Templates/ToolbarItems/ProjectStatusItem.html'));
        return $view->assignMultiple([
            'context' => $this->extensionConfiguration->get(Configuration::EXT_KEY)['backend']['context'] ? [
                'icon' => $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['global']['backendToolbar']['icon']['context'] ?? 'information-application-context',
                'name' => $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backendToolbar']['name'] ?? Environment::getContext()->__toString(),
                'color' => $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backendToolbar']['color'] ?? 'transparent',
                'textColor' => ColorUtility::getOptimalTextColor($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backendToolbar']['color']),
            ] : null,
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
        return 0;
    }
}
