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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Widget;
use PHPUnit\Framework\TestCase;

class WidgetTest extends TestCase
{
    public function testConstructorWithEmptyConfiguration(): void
    {
        $widget = new Widget();
        self::assertInstanceOf(Widget::class, $widget);
    }

    public function testConstructorWithConfiguration(): void
    {
        $config = [
            'color' => '#ff0000',
            'name' => 'Development',
            'textSize' => '24px',
        ];
        $widget = new Widget($config);
        self::assertEquals($config, $widget->getConfiguration());
    }

    public function testGetConfigurationReturnsConfiguration(): void
    {
        $config = [
            'color' => '#00ff00',
            'name' => 'Testing',
            'textSize' => '18px',
        ];
        $widget = new Widget($config);
        self::assertEquals($config, $widget->getConfiguration());
    }

    public function testInheritsFromAbstractIndicator(): void
    {
        $widget = new Widget();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\AbstractIndicator::class, $widget);
    }

    public function testImplementsIndicatorInterface(): void
    {
        $widget = new Widget();
        self::assertInstanceOf(\KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface::class, $widget);
    }
}
