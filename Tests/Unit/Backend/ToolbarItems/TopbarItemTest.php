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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Backend\ToolbarItems;

use KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\TopbarItem;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

/**
 * TopbarItemTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class TopbarItemTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [];
    }

    public function testConstructorWithExtensionConfiguration(): void
    {
        $extensionConfiguration = $this->createMock(ExtensionConfiguration::class);
        $topbarItem = new TopbarItem($extensionConfiguration);
        self::assertInstanceOf(TopbarItem::class, $topbarItem);
    }

    public function testCheckAccessReturnsTrue(): void
    {
        $extensionConfiguration = $this->createMock(ExtensionConfiguration::class);
        $topbarItem = new TopbarItem($extensionConfiguration);
        self::assertTrue($topbarItem->checkAccess());
    }

    public function testHasDropDownReturnsFalse(): void
    {
        $extensionConfiguration = $this->createMock(ExtensionConfiguration::class);
        $topbarItem = new TopbarItem($extensionConfiguration);
        self::assertFalse($topbarItem->hasDropDown());
    }

    public function testGetDropDownReturnsEmptyString(): void
    {
        $extensionConfiguration = $this->createMock(ExtensionConfiguration::class);
        $topbarItem = new TopbarItem($extensionConfiguration);
        self::assertEquals('', $topbarItem->getDropDown());
    }

    public function testGetAdditionalAttributesReturnsEmptyArray(): void
    {
        $extensionConfiguration = $this->createMock(ExtensionConfiguration::class);
        $topbarItem = new TopbarItem($extensionConfiguration);
        self::assertEquals([], $topbarItem->getAdditionalAttributes());
    }

    public function testGetIndexReturnsZero(): void
    {
        $extensionConfiguration = $this->createMock(ExtensionConfiguration::class);
        $topbarItem = new TopbarItem($extensionConfiguration);
        self::assertEquals(0, $topbarItem->getIndex());
    }

    public function testImplementsToolbarItemInterface(): void
    {
        $extensionConfiguration = $this->createMock(ExtensionConfiguration::class);
        $topbarItem = new TopbarItem($extensionConfiguration);
        self::assertInstanceOf(ToolbarItemInterface::class, $topbarItem);
    }
}
