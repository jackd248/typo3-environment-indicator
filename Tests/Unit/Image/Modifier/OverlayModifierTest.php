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

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\OverlayModifier;
use PHPUnit\Framework\TestCase;

class OverlayModifierTest extends TestCase
{
    public function testGetRequiredConfigurationKeys(): void
    {
        $modifier = new OverlayModifier([
            'path' => 'EXT:site/Resources/Public/Images/overlay.png',
            'size' => 0.5,
            'position' => 'bottom right',
            'padding' => 0.1,
        ]);

        self::assertEquals(['path', 'size', 'position', 'padding'], $modifier->getRequiredConfigurationKeys());
    }

    public function testInstantiationWithRequiredValues(): void
    {
        $modifier = new OverlayModifier([
            'path' => 'EXT:site/Resources/Public/Images/watermark.png',
            'size' => 0.3,
            'position' => 'top left',
            'padding' => 0.05,
        ]);

        self::assertInstanceOf(OverlayModifier::class, $modifier);
    }

    public function testInstantiationWithBottomRightPosition(): void
    {
        $modifier = new OverlayModifier([
            'path' => 'EXT:extension/Resources/Public/badge.svg',
            'size' => 0.4,
            'position' => 'bottom right',
            'padding' => 0.1,
        ]);

        self::assertInstanceOf(OverlayModifier::class, $modifier);
    }

    public function testInstantiationWithTopCenterPosition(): void
    {
        $modifier = new OverlayModifier([
            'path' => 'EXT:site/Resources/Public/logo.png',
            'size' => 0.6,
            'position' => 'top center',
            'padding' => 0.2,
        ]);

        self::assertInstanceOf(OverlayModifier::class, $modifier);
    }

    public function testInstantiationWithDifferentSizes(): void
    {
        $modifier1 = new OverlayModifier([
            'path' => 'EXT:site/Resources/Public/small.png',
            'size' => 0.1,
            'position' => 'center',
            'padding' => 0.01,
        ]);
        self::assertInstanceOf(OverlayModifier::class, $modifier1);

        $modifier2 = new OverlayModifier([
            'path' => 'EXT:site/Resources/Public/large.png',
            'size' => 0.8,
            'position' => 'center',
            'padding' => 0.05,
        ]);
        self::assertInstanceOf(OverlayModifier::class, $modifier2);
    }
}
