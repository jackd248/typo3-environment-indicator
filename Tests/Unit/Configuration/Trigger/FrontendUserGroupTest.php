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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Trigger;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\FrontendUserGroup;
use PHPUnit\Framework\TestCase;

/**
 * FrontendUserGroupTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
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
        $GLOBALS['TSFE'] = (object) [];
        $trigger = new FrontendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsFalseWhenNoUserGroups(): void
    {
        $GLOBALS['TSFE'] = (object) [
            'fe_user' => (object) [],
        ];
        $trigger = new FrontendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsTrueWhenUserIsInMatchingGroup(): void
    {
        $GLOBALS['TSFE'] = (object) [
            'fe_user' => (object) [
                'groupData' => ['uid' => [1, 2, 3]],
            ],
        ];
        $trigger = new FrontendUserGroup(2);
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsTrueWhenUserIsInOneOfMultipleGroups(): void
    {
        $GLOBALS['TSFE'] = (object) [
            'fe_user' => (object) [
                'groupData' => ['uid' => [1, 2, 3]],
            ],
        ];
        $trigger = new FrontendUserGroup(4, 5, 2);
        $result = $trigger->check();
        self::assertTrue($result);
    }

    public function testCheckReturnsFalseWhenUserIsNotInAnyGroup(): void
    {
        $GLOBALS['TSFE'] = (object) [
            'fe_user' => (object) [
                'groupData' => ['uid' => [1, 2, 3]],
            ],
        ];
        $trigger = new FrontendUserGroup(4, 5, 6);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckReturnsFalseWhenUserHasEmptyGroups(): void
    {
        $GLOBALS['TSFE'] = (object) [
            'fe_user' => (object) [
                'groupData' => ['uid' => []],
            ],
        ];
        $trigger = new FrontendUserGroup(1);
        $result = $trigger->check();
        self::assertFalse($result);
    }

    public function testCheckUsesStrictComparison(): void
    {
        $GLOBALS['TSFE'] = (object) [
            'fe_user' => (object) [
                'groupData' => ['uid' => [1, 2, 3]],
            ],
        ];
        // Test that int 4 doesn't match any group to ensure strict comparison
        $trigger = new FrontendUserGroup(4);
        $result = $trigger->check();
        self::assertFalse($result);
    }
}
