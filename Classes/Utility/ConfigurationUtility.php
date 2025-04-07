<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;

class ConfigurationUtility
{
    /*
    * @Deprecated
    */
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
        throw new \Exception(
            sprintf(
                'The "%s" method is deprecated and no longer support. Use the "%s" method instead. See the documentation for the correct usage.',
                __METHOD__,
                Configuration\Handler::class . '::addIndicator'
            ),
            5404480452
        );
    }
}
