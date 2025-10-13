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

use KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier\TriangleModifier;
use PHPUnit\Framework\TestCase;

/**
 * TriangleModifierTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
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
