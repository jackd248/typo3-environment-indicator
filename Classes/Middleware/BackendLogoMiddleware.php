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

namespace KonradMichalik\Typo3EnvironmentIndicator\Middleware;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Image\BackendLogoHandler;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * BackendLogoMiddleware.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class BackendLogoMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->isFeatureEnabled()) {
            return $handler->handle($request);
        }

        $currentBackendLogo = $this->getBackendLogo($this->extensionConfiguration, $request);
        $imageHandler = GeneralUtility::makeInstance(BackendLogoHandler::class);
        $newBackendLogo = $imageHandler->process($currentBackendLogo, $request);
        $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendLogo'] = $newBackendLogo;

        return $handler->handle($request);
    }

    protected function getBackendLogo(ExtensionConfiguration $extensionConfiguration, ServerRequestInterface $request): string
    {
        $backendLogo = $extensionConfiguration->get('backend', 'backendLogo');
        if (null !== $backendLogo && '' !== $backendLogo) {
            return $backendLogo;
        }

        return 'EXT:backend/Resources/Public/Images/typo3_logo_orange.svg';
    }

    private function isFeatureEnabled(): bool
    {
        $extensionConfig = $this->extensionConfiguration->get(Configuration::EXT_KEY);

        return ($extensionConfig['backend']['logo'] ?? false) === true;
    }
}
