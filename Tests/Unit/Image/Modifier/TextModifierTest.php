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

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\TextModifier;
use PHPUnit\Framework\TestCase;

class TextModifierTest extends TestCase
{
    public function testGetRequiredConfigurationKeys(): void
    {
        $modifier = new TextModifier([
            'text' => 'Test',
            'color' => '#ffffff'
        ]);
        
        self::assertEquals(['text', 'color'], $modifier->getRequiredConfigurationKeys());
    }

    public function testInstantiationWithRequiredValues(): void
    {
        $modifier = new TextModifier([
            'text' => 'Development',
            'color' => '#ffffff'
        ]);
        
        self::assertInstanceOf(TextModifier::class, $modifier);
    }

    public function testInstantiationWithOptionalValues(): void
    {
        $modifier = new TextModifier([
            'text' => 'Staging',
            'color' => '#ffffff',
            'font' => 'EXT:site/Resources/Private/Fonts/arial.ttf',
            'position' => 'top',
            'stroke' => [
                'color' => '#000000',
                'width' => 2
            ]
        ]);
        
        self::assertInstanceOf(TextModifier::class, $modifier);
    }

    public function testInstantiationWithStrokeConfiguration(): void
    {
        $modifier = new TextModifier([
            'text' => 'Production',
            'color' => '#ff0000',
            'stroke' => [
                'color' => '#000000',
                'width' => 1
            ]
        ]);
        
        self::assertInstanceOf(TextModifier::class, $modifier);
    }

    public function testInstantiationWithPositionTop(): void
    {
        $modifier = new TextModifier([
            'text' => 'Local',
            'color' => '#00ff00',
            'position' => 'top'
        ]);
        
        self::assertInstanceOf(TextModifier::class, $modifier);
    }

    public function testInstantiationWithPositionBottom(): void
    {
        $modifier = new TextModifier([
            'text' => 'Testing',
            'color' => '#0000ff',
            'position' => 'bottom'
        ]);
        
        self::assertInstanceOf(TextModifier::class, $modifier);
    }
}