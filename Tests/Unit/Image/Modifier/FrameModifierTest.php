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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Image\Modifier;

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\FrameModifier;
use PHPUnit\Framework\TestCase;

class FrameModifierTest extends TestCase
{
    public function testGetRequiredConfigurationKeys(): void
    {
        $modifier = new FrameModifier(['color' => '#ff0000']);
        self::assertEquals(['color'], $modifier->getRequiredConfigurationKeys());
    }

    public function testInstantiationWithRequiredValues(): void
    {
        $modifier = new FrameModifier(['color' => '#ff0000']);
        self::assertInstanceOf(FrameModifier::class, $modifier);
    }

    public function testInstantiationWithOptionalBorderSize(): void
    {
        $modifier = new FrameModifier([
            'color' => '#00ff00',
            'borderSize' => 10,
        ]);
        self::assertInstanceOf(FrameModifier::class, $modifier);
    }

    public function testInstantiationWithDifferentColors(): void
    {
        $modifier = new FrameModifier(['color' => 'blue']);
        self::assertInstanceOf(FrameModifier::class, $modifier);

        $modifier2 = new FrameModifier(['color' => '#336699']);
        self::assertInstanceOf(FrameModifier::class, $modifier2);

        $modifier3 = new FrameModifier(['color' => 'rgba(255, 0, 0, 0.5)']);
        self::assertInstanceOf(FrameModifier::class, $modifier3);
    }

    public function testInstantiationWithCustomBorderSize(): void
    {
        $modifier = new FrameModifier([
            'color' => '#000000',
            'borderSize' => 2,
        ]);
        self::assertInstanceOf(FrameModifier::class, $modifier);
    }
}
