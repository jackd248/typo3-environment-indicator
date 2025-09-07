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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\FrontendUserGroup;
use PHPUnit\Framework\TestCase;

/**
 * FrontendUserGroupTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class FrontendUserGroupTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        unset($GLOBALS['TSFE']);
    }

    public function testConstructorAcceptsSingleGroup(): void
    {
        $trigger = new FrontendUserGroup(1);
        self::assertInstanceOf(FrontendUserGroup::class, $trigger);
    }

    public function testConstructorAcceptsMultipleGroups(): void
    {
        $trigger = new FrontendUserGroup(1, 2, 3);
        self::assertInstanceOf(FrontendUserGroup::class, $trigger);
    }

    public function testCheckReturnsFalseWhenNoTSFE(): void
    {
        $trigger = new FrontendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsFalseWhenNoFrontendUser(): void
    {
        $GLOBALS['TSFE'] = (object)[];
        $trigger = new FrontendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsFalseWhenNoUserGroups(): void
    {
        $GLOBALS['TSFE'] = (object)[
            'fe_user' => (object)[],
        ];
        $trigger = new FrontendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsTrueWhenUserIsInMatchingGroup(): void
    {
        $GLOBALS['TSFE'] = (object)[
            'fe_user' => (object)[
                'groupData' => ['uid' => [1, 2, 3]],
            ],
        ];
        $trigger = new FrontendUserGroup(2);
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsTrueWhenUserIsInOneOfMultipleGroups(): void
    {
        $GLOBALS['TSFE'] = (object)[
            'fe_user' => (object)[
                'groupData' => ['uid' => [1, 2, 3]],
            ],
        ];
        $trigger = new FrontendUserGroup(4, 5, 2);
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseWhenUserIsNotInAnyGroup(): void
    {
        $GLOBALS['TSFE'] = (object)[
            'fe_user' => (object)[
                'groupData' => ['uid' => [1, 2, 3]],
            ],
        ];
        $trigger = new FrontendUserGroup(4, 5, 6);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsFalseWhenUserHasEmptyGroups(): void
    {
        $GLOBALS['TSFE'] = (object)[
            'fe_user' => (object)[
                'groupData' => ['uid' => []],
            ],
        ];
        $trigger = new FrontendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckUsesStrictComparison(): void
    {
        $GLOBALS['TSFE'] = (object)[
            'fe_user' => (object)[
                'groupData' => ['uid' => [1, 2, 3]],
            ],
        ];
        $trigger = new FrontendUserGroup('1');
        $result = $trigger->check();
        self::assertFalse($result);
    }
}
