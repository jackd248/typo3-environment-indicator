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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Indicator\Backend;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\AbstractIndicator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Topbar;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use PHPUnit\Framework\TestCase;

class TopbarTest extends TestCase
{
    public function testConstructorCreatesInstance(): void
    {
        $topbar = new Topbar();
        self::assertInstanceOf(Topbar::class, $topbar);
    }

    public function testExtendsAbstractIndicator(): void
    {
        $topbar = new Topbar();
        self::assertInstanceOf(AbstractIndicator::class, $topbar);
    }

    public function testImplementsIndicatorInterface(): void
    {
        $topbar = new Topbar();
        self::assertInstanceOf(IndicatorInterface::class, $topbar);
    }

    public function testConstructorWithConfiguration(): void
    {
        $config = ['text' => 'Development'];
        $topbar = new Topbar($config);
        self::assertInstanceOf(Topbar::class, $topbar);
    }
}
