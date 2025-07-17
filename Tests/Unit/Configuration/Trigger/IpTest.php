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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\Ip;
use PHPUnit\Framework\TestCase;

class IpTest extends TestCase
{
    private string $originalRemoteAddr;

    protected function setUp(): void
    {
        parent::setUp();
        // Store original value and set test value
        // @phpstan-ignore-next-line disallowed.variable
        $this->originalRemoteAddr = $_SERVER['REMOTE_ADDR'] ?? '';
        // @phpstan-ignore-next-line disallowed.variable
        $_SERVER['REMOTE_ADDR'] = '192.168.1.1';
    }

    protected function tearDown(): void
    {
        // Restore original value
        if ($this->originalRemoteAddr !== '') {
            // @phpstan-ignore-next-line disallowed.variable
            $_SERVER['REMOTE_ADDR'] = $this->originalRemoteAddr;
        } else {
            // @phpstan-ignore-next-line disallowed.variable
            unset($_SERVER['REMOTE_ADDR']);
        }
        parent::tearDown();
    }

    public function testCheckReturnsTrueForMatchingIp(): void
    {
        $trigger = new Ip('192.168.1.1');
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseForNonMatchingIp(): void
    {
        $trigger = new Ip('192.168.1.2');
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsTrueForMatchingIpInMultipleIps(): void
    {
        $trigger = new Ip('192.168.1.2', '192.168.1.1', '192.168.1.3');
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseForNonMatchingIpInMultipleIps(): void
    {
        $trigger = new Ip('192.168.1.2', '192.168.1.3', '192.168.1.4');
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsTrueForMatchingCidrRange(): void
    {
        $trigger = new Ip('192.168.1.0/24');
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseForNonMatchingCidrRange(): void
    {
        $trigger = new Ip('192.168.2.0/24');
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsTrueForMatchingCidrRangeWith16BitMask(): void
    {
        $trigger = new Ip('192.168.0.0/16');
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseForNonMatchingCidrRangeWith16BitMask(): void
    {
        $trigger = new Ip('192.169.0.0/16');
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsTrueForMatchingCidrRangeWith8BitMask(): void
    {
        $trigger = new Ip('192.0.0.0/8');
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseForNonMatchingCidrRangeWith8BitMask(): void
    {
        $trigger = new Ip('10.0.0.0/8');
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckWithIPv6Address(): void
    {
        // Temporarily set IPv6 address for testing
        // @phpstan-ignore-next-line disallowed.variable
        $originalAddr = $_SERVER['REMOTE_ADDR'];
        // @phpstan-ignore-next-line disallowed.variable
        $_SERVER['REMOTE_ADDR'] = '2001:db8::1';

        $trigger = new Ip('2001:db8::1');
        $result = $trigger->check();
        self::assertTrue($result);

        // Restore original address
        // @phpstan-ignore-next-line disallowed.variable
        $_SERVER['REMOTE_ADDR'] = $originalAddr;
    }

    public function testCheckWithIPv6CidrRange(): void
    {
        // Temporarily set IPv6 address for testing
        // @phpstan-ignore-next-line disallowed.variable
        $originalAddr = $_SERVER['REMOTE_ADDR'];
        // @phpstan-ignore-next-line disallowed.variable
        $_SERVER['REMOTE_ADDR'] = '2001:db8::1';

        $trigger = new Ip('2001:db8::/32');
        $result = $trigger->check();
        self::assertTrue($result);

        // Restore original address
        // @phpstan-ignore-next-line disallowed.variable
        $_SERVER['REMOTE_ADDR'] = $originalAddr;
    }
}
