<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;

class Handler
{
    /**
    * Adds a new indicator/trigger configuration.
    *
    * @param TriggerInterface[] $triggers
    * @param IndicatorInterface[] $indicators
    */
    public static function addIndicator(array $triggers = [], array $indicators = []): void
    {
        $configuration = [
            'triggers' => [],
            'indicators' => [],
        ];
        foreach ($triggers as $trigger) {
            $configuration['triggers'][] = $trigger;
        }

        foreach ($indicators as $indicator) {
            $configuration['indicators'][] = $indicator;
        }

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'][] = $configuration;
    }

    /**
    * Resolves the current indicators based on the registered configurations and the checked triggers.
    *
    * @return array Current indicators
    */
    public static function resolveIndicators(): array
    {
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'])) {
            return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'];
        }

        foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'] as $configuration) {
            foreach ($configuration['triggers'] as $trigger) {
                if (!$trigger->check()) {
                    continue 2;
                }
            }

            foreach ($configuration['indicators'] as $indicator) {
                if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicator::class])) {
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicator::class] = array_merge_recursive(
                        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicator::class],
                        $indicator->getConfiguration()
                    );
                } else {
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicator::class] = $indicator->getConfiguration();
                }
            }
        }

        return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'];
    }
}
