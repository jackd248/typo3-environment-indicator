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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Image\Modifier;

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\CircleModifier;
use PHPUnit\Framework\TestCase;

/**
 * CircleModifierTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class CircleModifierTest extends TestCase
{
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
