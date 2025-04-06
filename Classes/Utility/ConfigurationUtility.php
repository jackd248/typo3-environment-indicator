<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;

class ConfigurationUtility
{
    public static function configByContext(
        string $applicationContext,
        ?array $frontendHintConfiguration = [],
        ?array $backendToolbarConfiguration = [],
        ?array $backendTopbarConfiguration = [],
        ?array $faviconModifierConfiguration = [],
        ?array $faviconModifierFrontendConfiguration = [],
        ?array $faviconModifierBackendConfiguration = [],
        ?array $frontendImageModifierConfiguration = [],
        ?array $backendLogoModifierConfiguration = [],
        ?array $globalImageModifierConfiguration = []
    ): void {
        if ($frontendHintConfiguration !== []) {
            if ($frontendHintConfiguration === null) {
                unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontend']['hint']);
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontend']['hint'] = $frontendHintConfiguration;
            }
        }

        if ($backendToolbarConfiguration !== []) {
            if ($backendToolbarConfiguration === null) {
                unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['toolbar']);
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['toolbar'] = $backendToolbarConfiguration;
            }
        }

        if ($backendTopbarConfiguration !== []) {
            if ($backendTopbarConfiguration === null) {
                unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['topbar']);
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['topbar'] = $backendTopbarConfiguration;
            }
        }

        if ($faviconModifierConfiguration !== []) {
            if ($faviconModifierConfiguration === null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['both']['favicon'] = [];
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['both']['favicon'] = $faviconModifierConfiguration;
            }
        }

        if ($faviconModifierFrontendConfiguration !== []) {
            if ($faviconModifierFrontendConfiguration === null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontend']['favicon'] = [];
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontend']['favicon'] = $faviconModifierFrontendConfiguration;
            }
        }

        if ($faviconModifierBackendConfiguration !== []) {
            if ($faviconModifierBackendConfiguration === null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['favicon'] = [];
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['favicon'] = $faviconModifierBackendConfiguration;
            }
        }

        if ($frontendImageModifierConfiguration !== []) {
            if ($frontendImageModifierConfiguration === null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontend']['image'] = [];
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontend']['image'] = $frontendImageModifierConfiguration;
            }
        }

        if ($backendLogoModifierConfiguration !== []) {
            if ($backendLogoModifierConfiguration === null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['logo'] = [];
            } else {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['logo'] = $backendLogoModifierConfiguration;
            }
        }

        if ($globalImageModifierConfiguration !== []) {
            if ($globalImageModifierConfiguration !== null) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['both']['favicon'] = $globalImageModifierConfiguration;
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontend']['image'] = $globalImageModifierConfiguration;
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backend']['logo'] = $globalImageModifierConfiguration;
            }
        }
    }
}
