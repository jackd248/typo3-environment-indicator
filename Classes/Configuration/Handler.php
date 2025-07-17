<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "typo3_environment_indicator".
 *
 * Copyright (C) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

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

        if (($configuration['triggers'] === [] && $configuration['indicators'] === []) ||
            !isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['configuration'])
        ) {
            return;
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
        if (($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] ?? []) !== []) {
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
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicator::class] = array_replace_recursive(
                        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicator::class],
                        $indicator->getConfiguration()
                    );
                } else {
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'][$indicator::class] = $indicator->getConfiguration();
                }
            }
        }

        return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] ?? [];
    }
}
