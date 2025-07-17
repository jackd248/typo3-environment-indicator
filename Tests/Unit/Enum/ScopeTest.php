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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Enum;

use KonradMichalik\Typo3EnvironmentIndicator\Enum\Scope;
use PHPUnit\Framework\TestCase;

class ScopeTest extends TestCase
{
    public function testScopeValues(): void
    {
        $scopes = Scope::cases();

        self::assertCount(4, $scopes);
        self::assertEquals(Scope::Both, $scopes[0]);
        self::assertEquals(Scope::Frontend, $scopes[1]);
        self::assertEquals(Scope::Backend, $scopes[2]);
        self::assertEquals(Scope::Global, $scopes[3]);
    }

    public function testScopeNames(): void
    {
        self::assertEquals('Both', Scope::Both->name);
        self::assertEquals('Frontend', Scope::Frontend->name);
        self::assertEquals('Backend', Scope::Backend->name);
        self::assertEquals('Global', Scope::Global->name);
    }
}
