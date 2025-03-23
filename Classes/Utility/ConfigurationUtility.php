<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;

class ConfigurationUtility
{
    public static function configByContext(string $applicationContext, ?array $frontendHintConfiguration = [], ?array $backendToolbarConfiguration = [], ?array $backendTopbarConfiguration = [], ?array $faviconModifierConfiguration = [], ?array $faviconModifierFrontendConfiguration = [], ?array $faviconModifierBackendConfiguration = []): void
    {
        if ($frontendHintConfiguration !== []) {
            if ($frontendHintConfiguration === null) {
                unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontendHint']);
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontendHint'] = $frontendHintConfiguration;
            }
        }

        if ($backendToolbarConfiguration !== []) {
            if ($backendToolbarConfiguration === null) {
                unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backendToolbar']);
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backendToolbar'] = $backendToolbarConfiguration;
            }
        }

        if ($backendTopbarConfiguration !== []) {
            if ($backendTopbarConfiguration === null) {
                unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backendTopbar']);
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backendTopbar'] = $backendTopbarConfiguration;
            }
        }

        if ($faviconModifierConfiguration !== []) {
            if ($faviconModifierConfiguration === null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon']['*'] = [];
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon']['*'] = $faviconModifierConfiguration;
            }
        }

        if ($faviconModifierFrontendConfiguration !== []) {
            if ($faviconModifierFrontendConfiguration === null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon']['frontend'] = [];
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon']['frontend'] = $faviconModifierFrontendConfiguration;
            }
        }

        if ($faviconModifierBackendConfiguration !== []) {
            if ($faviconModifierBackendConfiguration === null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon']['backend'] = [];
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon']['backend'] = $faviconModifierBackendConfiguration;
            }
        }
    }
}
