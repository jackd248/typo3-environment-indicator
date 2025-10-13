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

namespace KonradMichalik\Typo3EnvironmentIndicator\Middleware;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FaviconHandler;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * BackendFaviconMiddleware.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
class BackendFaviconMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->isFeatureEnabled()) {
            return $handler->handle($request);
        }

        $this->processFavicon($request);

        return $handler->handle($request);
    }

    private function isFeatureEnabled(): bool
    {
        $extensionConfig = $this->extensionConfiguration->get(Configuration::EXT_KEY);

        return true === (bool) ($extensionConfig['backend']['favicon'] ?? false);
    }

    private function processFavicon(ServerRequestInterface $request): void
    {
        $currentFavicon = $this->getCurrentFavicon();
        $faviconHandler = GeneralUtility::makeInstance(FaviconHandler::class);
        $newFavicon = $faviconHandler->process($currentFavicon, $request);

        $this->setBackendFavicon($newFavicon);
    }

    private function getCurrentFavicon(): string
    {
        $backendFavicon = $this->extensionConfiguration->get('backend', 'backendFavicon');

        if (null !== $backendFavicon && '' !== $backendFavicon) {
            return $backendFavicon;
        }

        return 'EXT:backend/Resources/Public/Icons/favicon.ico';
    }

    private function setBackendFavicon(string $faviconPath): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendFavicon'] = $faviconPath;
    }
}
