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

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\CircleModifier;
use PHPUnit\Framework\TestCase;

class CircleModifierTest extends TestCase
{
    public function testGetRequiredConfigurationKeys(): void
    {
        $modifier = new CircleModifier([
            'color' => '#ff0000',
            'size' => 0.5,
            'padding' => 0.1,
            'position' => 'bottom right',
        ]);

        $requiredKeys = $modifier->getRequiredConfigurationKeys();
        self::assertEquals(['color', 'size', 'padding', 'position'], $requiredKeys);
    }

    public function testInstantiationWithRequiredValues(): void
    {
        $modifier = new CircleModifier([
            'color' => '#ff0000',
            'size' => 0.4,
            'padding' => 0.1,
            'position' => 'bottom right',
        ]);

        self::assertInstanceOf(CircleModifier::class, $modifier);
    }

    public function testInstantiationWithCustomValues(): void
    {
        $modifier = new CircleModifier([
            'color' => '#00ff00',
            'size' => 0.6,
            'padding' => 0.2,
            'position' => 'top left',
        ]);

        self::assertInstanceOf(CircleModifier::class, $modifier);
    }
}
