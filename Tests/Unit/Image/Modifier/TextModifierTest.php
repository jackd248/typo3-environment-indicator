<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Image\Modifier;

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\TextModifier;
use PHPUnit\Framework\TestCase;

/**
 * TextModifierTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class TextModifierTest extends TestCase
{
    public function testInstantiationWithRequiredValues(): void
    {
        $modifier = new TextModifier([
            'text' => 'Development',
            'color' => '#ffffff',
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
                'width' => 2,
            ],
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
                'width' => 1,
            ],
        ]);

        self::assertInstanceOf(TextModifier::class, $modifier);
    }

    public function testInstantiationWithPositionTop(): void
    {
        $modifier = new TextModifier([
            'text' => 'Local',
            'color' => '#00ff00',
            'position' => 'top',
        ]);

        self::assertInstanceOf(TextModifier::class, $modifier);
    }

    public function testInstantiationWithPositionBottom(): void
    {
        $modifier = new TextModifier([
            'text' => 'Testing',
            'color' => '#0000ff',
            'position' => 'bottom',
        ]);

        self::assertInstanceOf(TextModifier::class, $modifier);
    }
}
