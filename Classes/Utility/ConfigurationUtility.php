<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;

class ConfigurationUtility
{
    const OPTION_FRONTEND_HINT = 1 << 0;
    const OPTION_BACKEND_TOOLBAR = 1 << 1;
    const OPTION_FAVICON = 1 << 2;

    /**
    * @param string $applicationContext - application context
    * @param string $modifierClass - class name of the modifier
    * @param array $configuration - configuration for the modifier
    * @param string $requestContext - '*' for all requests, 'backend' for backend requests, 'frontend' for frontend requests
    */
    public static function addFaviconModifierConfigurationByContext(string $applicationContext, string $modifierClass, array $configuration = [], string $requestContext = '*'): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon'][$requestContext][$modifierClass] = $configuration;
    }

    /**
    * @param string $applicationContext - application context
    * @param array $configuration - configuration for the frontend hint
    */
    public static function addFrontendHintConfigurationByContext(string $applicationContext, array $configuration): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontendHint'] = $configuration;
    }

    /**
    * @param string $applicationContext - application context
    * @param array $configuration - configuration for the backend toolbar
    */
    public static function addBackendToolbarConfigurationByContext(string $applicationContext, array $configuration): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backendToolbar'] = $configuration;
    }

    /**
    * Helper function to add the main color configuration to the context
    *
    * @param string $applicationContext - application context
    * @param string $color - color
    * @param int $options - options to apply the color to, e.g. OPTION_FRONTEND_HINT | OPTION_BACKEND_TOOLBAR | OPTION_FAVICON
    */
    public static function addMainColorConfigurationByContext(string $applicationContext, string $color, int $options = self::OPTION_FRONTEND_HINT | self::OPTION_BACKEND_TOOLBAR | self::OPTION_FAVICON): void
    {
        if ($options & self::OPTION_FRONTEND_HINT) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['frontendHint']['color'] = $color;
        }
        if ($options & self::OPTION_BACKEND_TOOLBAR) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['backendToolbar']['color'] = $color;
        }
        if ($options & self::OPTION_FAVICON) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon'] as $requestContext => $modifiers) {
                foreach ($modifiers as $modifierClass => $modifierConfiguration) {
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][$applicationContext]['favicon'][$requestContext][$modifierClass]['color'] = $color;
                }
            }
        }
    }
}
