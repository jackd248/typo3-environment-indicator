<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Service;

use Exception;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service\TriggerEvaluator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * TriggerEvaluatorTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
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
        $trigger->expects(self::once())->method('check')->willThrowException(new Exception('Test exception'));

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
        $invalidTrigger = new stdClass();

        $result = $this->triggerEvaluator->validateTriggers([$trigger, $invalidTrigger]);
        self::assertFalse($result);
    }

    public function testValidateTriggersReturnsTrueForEmptyArray(): void
    {
        $result = $this->triggerEvaluator->validateTriggers([]);
        self::assertTrue($result);
    }
}
