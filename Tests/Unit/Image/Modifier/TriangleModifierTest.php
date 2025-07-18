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

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\TriangleModifier;
use PHPUnit\Framework\TestCase;

class TriangleModifierTest extends TestCase
{
    public function testInstantiationWithRequiredValues(): void
    {
        $modifier = new TriangleModifier([
            'color' => '#ff0000',
        ]);

        self::assertInstanceOf(TriangleModifier::class, $modifier);
    }

    public function testInstantiationWithCustomValues(): void
    {
        $modifier = new TriangleModifier([
            'color' => '#00ff00',
        ]);

        self::assertInstanceOf(TriangleModifier::class, $modifier);
    }
}
