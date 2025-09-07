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

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;

/**
 * TriggerEvaluator.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class TriggerEvaluator
{
    /**
     * Evaluates all triggers in a configuration.
     *
     * @param TriggerInterface[] $triggers Array of trigger objects
     * @return bool True if all triggers pass, false otherwise
     */
    public function evaluateTriggers(array $triggers): bool
    {
        if ($triggers === []) {
            return true;
        }

        foreach ($triggers as $trigger) {
            if (!$this->evaluateTrigger($trigger)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Evaluates a single trigger.
     *
     * @param TriggerInterface $trigger The trigger to evaluate
     * @return bool True if the trigger passes, false otherwise
     */
    protected function evaluateTrigger(TriggerInterface $trigger): bool
    {
        try {
            return $trigger->check();
        } catch (\Throwable $e) {
            error_log('Trigger evaluation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Validates that triggers are properly configured.
     *
     * @param array $triggers Array of potential trigger objects
     * @return bool True if all triggers are valid, false otherwise
     */
    public function validateTriggers(array $triggers): bool
    {
        foreach ($triggers as $trigger) {
            if (!$trigger instanceof TriggerInterface) {
                return false;
            }
        }

        return true;
    }
}
