<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\ViewHelpers;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Service\HandlerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class FaviconViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('favicon', 'string', 'Favicon path');
    }

    public function render(): string
    {
        $favicon = $this->renderChildren();
        $handler = GeneralUtility::makeInstance($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['general']['favicon']['handler']);
        /** @var HandlerInterface $handler */
        return $handler->process($favicon);
    }
}
