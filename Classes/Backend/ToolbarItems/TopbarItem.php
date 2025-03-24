<?php

namespace KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ColorUtility;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class TopbarItem implements ToolbarItemInterface
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
            !isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backendTopbar'])) {
            return '';
        }

        if (!$this->extensionConfiguration->get(Configuration::EXT_KEY)['backend']['contextProduction'] && Environment::getContext()->__toString() === 'Production') {
            return '';
        }

        $color = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backendTopbar']['color'] ?? [];

        if (empty($color)) {
            return '';
        }

        $backendCssPath =  Environment::getPublicPath() . '/typo3temp/assets/css/' . Configuration::EXT_KEY . '/';
        if (!file_exists($backendCssPath)) {
            GeneralUtility::mkdir_deep($backendCssPath);
        }

        $removeTransition = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backendTopbar']['removeTransition'] ?? false;
        $backendCssFile = sprintf(
            '%sbackend-%s.css',
            $backendCssPath,
            md5(implode('_', [Environment::getContext()->__toString(), $color, $removeTransition]))
        );

        if (!file_exists($backendCssFile)) {
            $textColor = ColorUtility::getOptimalTextColor($color);
            $subTextColor = ColorUtility::getOptimalTextColor($color, 0.8);

            /*
            * ToDo: StandaloneView is deprecated in v13
            */
            $view = GeneralUtility::makeInstance(StandaloneView::class);
            $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:' . Configuration::EXT_KEY
                . '/Resources/Private/Templates/ToolbarItems/TopbarItem.html'));
            $fileContent = $view->assignMultiple([
                'color' => $color,
                'textColor' => $textColor,
                'subTextColor' => $subTextColor,
                'removeTransition' => $removeTransition,
            ])->render();

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
}
