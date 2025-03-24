<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Middleware;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Service\ImageHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BackendLogoMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->extensionConfiguration->get(Configuration::EXT_KEY)['backend']['logo'] ?? false) {
            $currentBackendLogo = $this->getBackendLogo($this->extensionConfiguration, $request);
            $imageHandler = GeneralUtility::makeInstance(ImageHandler::class);
            $newBackendLogo = $imageHandler->process($currentBackendLogo, $request);
            $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendLogo'] = $newBackendLogo;
        }

        return $handler->handle($request);
    }

    protected function getBackendLogo(ExtensionConfiguration $extensionConfiguration, ServerRequestInterface $request): string
    {
        $backendLogo = $extensionConfiguration->get('backend', 'backendLogo');
        if (!empty($backendLogo)) {
            return $backendLogo;
        }
        return 'EXT:backend/Resources/Public/Images/typo3_logo_orange.svg';
    }
}
