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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Utility\ViewFactoryHelper;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * ViewFactoryHelperTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
class ViewFactoryHelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $GLOBALS['TYPO3_CONF_VARS'] = [
            'SYS' => [
                'Objects' => [],
            ],
        ];
    }

    public function testRenderViewMethodIsStatic(): void
    {
        $reflection = new ReflectionClass(ViewFactoryHelper::class);
        $method = $reflection->getMethod('renderView');
        self::assertTrue($method->isStatic());
    }

    public function testRenderView12MethodExists(): void
    {
        $reflection = new ReflectionClass(ViewFactoryHelper::class);
        self::assertTrue($reflection->hasMethod('renderView12'));
        self::assertTrue($reflection->getMethod('renderView12')->isPrivate());
        self::assertTrue($reflection->getMethod('renderView12')->isStatic());
    }

    public function testRenderView13MethodExists(): void
    {
        $reflection = new ReflectionClass(ViewFactoryHelper::class);
        self::assertTrue($reflection->hasMethod('renderView13'));
        self::assertTrue($reflection->getMethod('renderView13')->isPrivate());
        self::assertTrue($reflection->getMethod('renderView13')->isStatic());
    }

    public function testRenderViewParameterSignature(): void
    {
        $reflection = new ReflectionClass(ViewFactoryHelper::class);
        $method = $reflection->getMethod('renderView');
        $parameters = $method->getParameters();

        self::assertCount(3, $parameters);
        self::assertEquals('template', $parameters[0]->getName());
        self::assertEquals('values', $parameters[1]->getName());
        self::assertEquals('request', $parameters[2]->getName());
        self::assertTrue($parameters[2]->allowsNull());
    }

    public function testRenderView12ParameterSignature(): void
    {
        $reflection = new ReflectionClass(ViewFactoryHelper::class);
        $method = $reflection->getMethod('renderView12');
        $parameters = $method->getParameters();

        self::assertCount(2, $parameters);
        self::assertEquals('template', $parameters[0]->getName());
        self::assertEquals('values', $parameters[1]->getName());
    }

    public function testRenderView13ParameterSignature(): void
    {
        $reflection = new ReflectionClass(ViewFactoryHelper::class);
        $method = $reflection->getMethod('renderView13');
        $parameters = $method->getParameters();

        self::assertCount(3, $parameters);
        self::assertEquals('template', $parameters[0]->getName());
        self::assertEquals('values', $parameters[1]->getName());
        self::assertEquals('request', $parameters[2]->getName());
        self::assertTrue($parameters[2]->allowsNull());
    }
}
