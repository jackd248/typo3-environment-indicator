<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;

class Handler
{
    public static function addIndicator(array $triggers = [], array $indicators = []): void
    {
        foreach ($triggers as $trigger) {
            /* @var TriggerInterface $trigger */
            if (!$trigger instanceof TriggerInterface) {
                throw new \InvalidArgumentException('Trigger must implement TriggerInterface', 9746359720);
            }

            if (!$trigger->check()) {
                return;
            }
        }

        foreach ($indicators as $indicator) {
            if (!$indicator instanceof IndicatorInterface) {
                throw new \InvalidArgumentException('Indicator must implement IndicatorInterface', 6425216089);
            }

            /* @var IndicatorInterface $indicator */
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicator::class] = $indicator->getConfiguration();
        }
    }
}
