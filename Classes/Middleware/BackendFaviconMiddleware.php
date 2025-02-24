<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Middleware;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Service\HandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Backend\Template\PageRendererBackendSetupTrait;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BackendFaviconMiddleware implements MiddlewareInterface
{
    use PageRendererBackendSetupTrait;

    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->extensionConfiguration->get(Configuration::EXT_KEY)['backend']['favicon']) {
            $currentBackendFavicon = $this->getBackendFavicon($this->extensionConfiguration, $request);
            $faviconHandler = GeneralUtility::makeInstance($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['global']['favicon']['handler']);
            /** @var HandlerInterface $faviconHandler */
            $newBackendFavicon = $faviconHandler->process($currentBackendFavicon);
            $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendFavicon'] = $newBackendFavicon;
        }

        return $handler->handle($request);
    }

    protected function getBackendFavicon(ExtensionConfiguration $extensionConfiguration, ServerRequestInterface $request): string
    {
        $backendFavicon = $extensionConfiguration->get('backend', 'backendFavicon');
        if (!empty($backendFavicon)) {
            return $backendFavicon;
        }
        return 'EXT:backend/Resources/Public/Icons/favicon.ico';
    }
}
