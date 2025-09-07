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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Trigger;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\Custom;
use PHPUnit\Framework\TestCase;

/**
 * CustomTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class CustomTest extends TestCase
{
    public function testConstructorAcceptsClosure(): void
    {
        $closure = fn() => true;
        $trigger = new Custom($closure);
        self::assertInstanceOf(Custom::class, $trigger);
    }

    public function testConstructorAcceptsStaticMethodString(): void
    {
        $staticMethod = self::class . '::staticTestMethod';
        $trigger = new Custom($staticMethod);
        self::assertInstanceOf(Custom::class, $trigger);
    }

    public function testConstructorThrowsExceptionForInvalidFunction(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1726357767);
        $this->expectExceptionMessage('Function must be a callable or a valid static method string.');

        new Custom('invalidFunction');
    }

    public function testCheckReturnsTrueForTrueClosure(): void
    {
        $closure = fn() => true;
        $trigger = new Custom($closure);
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseForFalseClosure(): void
    {
        $closure = fn() => false;
        $trigger = new Custom($closure);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckCallsStaticMethod(): void
    {
        $trigger = new Custom(self::class . '::staticTestMethod');
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public static function staticTestMethod(): bool
    {
        return true;
    }
}
