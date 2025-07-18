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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service\TriggerEvaluator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;
use PHPUnit\Framework\TestCase;

class TriggerEvaluatorTest extends TestCase
{
    private TriggerEvaluator $triggerEvaluator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->triggerEvaluator = new TriggerEvaluator();
    }

    public function testEvaluateTriggersReturnsTrueForEmptyArray(): void
    {
        self::assertTrue($this->triggerEvaluator->evaluateTriggers([]));
    }

    public function testEvaluateTriggersReturnsTrueWhenAllTriggersPass(): void
    {
        $trigger1 = $this->createMock(TriggerInterface::class);
        $trigger1->expects(self::once())->method('check')->willReturn(true);

        $trigger2 = $this->createMock(TriggerInterface::class);
        $trigger2->expects(self::once())->method('check')->willReturn(true);

        $result = $this->triggerEvaluator->evaluateTriggers([$trigger1, $trigger2]);
        self::assertTrue($result);
    }

    public function testEvaluateTriggersReturnsFalseWhenOneTriggerFails(): void
    {
        $trigger1 = $this->createMock(TriggerInterface::class);
        $trigger1->expects(self::once())->method('check')->willReturn(true);

        $trigger2 = $this->createMock(TriggerInterface::class);
        $trigger2->expects(self::once())->method('check')->willReturn(false);

        $result = $this->triggerEvaluator->evaluateTriggers([$trigger1, $trigger2]);
        self::assertFalse($result);
    }

    public function testEvaluateTriggersHandlesException(): void
    {
        $trigger = $this->createMock(TriggerInterface::class);
        $trigger->expects(self::once())->method('check')->willThrowException(new \Exception('Test exception'));

        $result = $this->triggerEvaluator->evaluateTriggers([$trigger]);
        self::assertFalse($result);
    }

    public function testValidateTriggersReturnsTrueForValidTriggers(): void
    {
        $trigger1 = $this->createMock(TriggerInterface::class);
        $trigger2 = $this->createMock(TriggerInterface::class);

        $result = $this->triggerEvaluator->validateTriggers([$trigger1, $trigger2]);
        self::assertTrue($result);
    }

    public function testValidateTriggersReturnsFalseForInvalidTriggers(): void
    {
        $trigger = $this->createMock(TriggerInterface::class);
        $invalidTrigger = new \stdClass();

        $result = $this->triggerEvaluator->validateTriggers([$trigger, $invalidTrigger]);
        self::assertFalse($result);
    }

    public function testValidateTriggersReturnsTrueForEmptyArray(): void
    {
        $result = $this->triggerEvaluator->validateTriggers([]);
        self::assertTrue($result);
    }
}
