<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContextUtility
{
    public function getContext(): string
    {
        return Environment::getContext()->__toString();
    }

    public function getColor(): string
    {
        return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['frontendHint']['color'] ?? 'transparent';
    }

    public function getTextColor(): string
    {
        return ColorUtility::getOptimalTextColor($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['frontendHint']['color'] ?? 'transparent');
    }

    public function getPositionX(): string
    {
        return explode(' ', $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['frontendHint']['position'])[0];
    }

    public function getPositionY(): string
    {
        return explode(' ', $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['frontendHint']['position'])[1];
    }

    public function getTitle(): string
    {
        $title = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['frontendHint']['text'] ?? null;
        if ($title !== null) {
            return $title;
        }
        $pid = $GLOBALS['TSFE']->id;
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        $site = $siteFinder->getSiteByPageId($pid);
        return $site->getConfiguration()['websiteTitle'] ?: $site->getIdentifier();
    }
}
