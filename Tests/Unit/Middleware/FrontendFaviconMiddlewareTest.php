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

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Middleware;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Middleware\FrontendFaviconMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

/**
 * FrontendFaviconMiddlewareTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
final class FrontendFaviconMiddlewareTest extends TestCase
{
    public function testProcessSkipsWhenFeatureDisabled(): void
    {
        $extensionConfig = $this->createMock(ExtensionConfiguration::class);
        $extensionConfig->method('get')
            ->with(Configuration::EXT_KEY)
            ->willReturn(['frontend' => ['favicon' => false]]);

        $middleware = new FrontendFaviconMiddleware($extensionConfig);

        $request = $this->createMock(ServerRequestInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $handler->expects(self::once())
            ->method('handle')
            ->with($request)
            ->willReturn($response);

        $result = $middleware->process($request, $handler);
        self::assertSame($response, $result);
    }

    public function testProcessSkipsWhenFeatureMissing(): void
    {
        $extensionConfig = $this->createMock(ExtensionConfiguration::class);
        $extensionConfig->method('get')
            ->with(Configuration::EXT_KEY)
            ->willReturn(['frontend' => []]);

        $middleware = new FrontendFaviconMiddleware($extensionConfig);

        $request = $this->createMock(ServerRequestInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $handler->expects(self::once())
            ->method('handle')
            ->with($request)
            ->willReturn($response);

        $result = $middleware->process($request, $handler);
        self::assertSame($response, $result);
    }

    public function testProcessSkipsWhenConfigMissing(): void
    {
        $extensionConfig = $this->createMock(ExtensionConfiguration::class);
        $extensionConfig->method('get')
            ->with(Configuration::EXT_KEY)
            ->willReturn([]);

        $middleware = new FrontendFaviconMiddleware($extensionConfig);

        $request = $this->createMock(ServerRequestInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $handler->expects(self::once())
            ->method('handle')
            ->with($request)
            ->willReturn($response);

        $result = $middleware->process($request, $handler);
        self::assertSame($response, $result);
    }

    public function testProcessReturnsResponseWhenFeatureEnabled(): void
    {
        $extensionConfig = $this->createMock(ExtensionConfiguration::class);
        $extensionConfig->method('get')
            ->with(Configuration::EXT_KEY)
            ->willReturn(['frontend' => ['favicon' => true]]);

        $middleware = new FrontendFaviconMiddleware($extensionConfig);

        $request = $this->createMock(ServerRequestInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $handler->expects(self::once())
            ->method('handle')
            ->willReturn($response);

        $result = $middleware->process($request, $handler);
        self::assertSame($response, $result);
    }
}
