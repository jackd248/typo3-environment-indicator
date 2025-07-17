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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\BackendUserGroup;
use PHPUnit\Framework\TestCase;

class BackendUserGroupTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        unset($GLOBALS['BE_USER']);
    }

    public function testConstructorAcceptsSingleGroup(): void
    {
        $trigger = new BackendUserGroup(1);
        self::assertInstanceOf(BackendUserGroup::class, $trigger);
    }

    public function testConstructorAcceptsMultipleGroups(): void
    {
        $trigger = new BackendUserGroup(1, 2, 3);
        self::assertInstanceOf(BackendUserGroup::class, $trigger);
    }

    public function testCheckReturnsFalseWhenNoBackendUser(): void
    {
        $trigger = new BackendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsFalseWhenNoUserGroups(): void
    {
        $GLOBALS['BE_USER'] = (object)[];
        $trigger = new BackendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsTrueWhenUserIsInMatchingGroup(): void
    {
        $GLOBALS['BE_USER'] = (object)['userGroupsUID' => [1, 2, 3]];
        $trigger = new BackendUserGroup(2);
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsTrueWhenUserIsInOneOfMultipleGroups(): void
    {
        $GLOBALS['BE_USER'] = (object)['userGroupsUID' => [1, 2, 3]];
        $trigger = new BackendUserGroup(4, 5, 2);
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseWhenUserIsNotInAnyGroup(): void
    {
        $GLOBALS['BE_USER'] = (object)['userGroupsUID' => [1, 2, 3]];
        $trigger = new BackendUserGroup(4, 5, 6);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsFalseWhenUserHasEmptyGroups(): void
    {
        $GLOBALS['BE_USER'] = (object)['userGroupsUID' => []];
        $trigger = new BackendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckUsesStrictComparison(): void
    {
        $GLOBALS['BE_USER'] = (object)['userGroupsUID' => [1, 2, 3]];
        $trigger = new BackendUserGroup('1');
        $result = $trigger->check();
        self::assertFalse($result);
    }
}
