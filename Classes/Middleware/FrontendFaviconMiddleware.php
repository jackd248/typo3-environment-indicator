<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Middleware;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Service\HandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FrontendFaviconMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /*
        * $GLOBALS['TSFE'] is deprecated in v13
        * @see https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/RequestLifeCycle/RequestAttributes/FrontendController.html
        */
        if ($this->extensionConfiguration->get(Configuration::EXT_KEY)['frontend']['favicon'] &&
            is_array($GLOBALS['TSFE']->pSetup) &&
            array_key_exists('shortcutIcon', $GLOBALS['TSFE']->pSetup) &&
            $GLOBALS['TSFE']->pSetup['shortcutIcon'] !== ''
        ) {
            $currentFrontendFavicon = $GLOBALS['TSFE']->pSetup['shortcutIcon'];
            $faviconHandler = GeneralUtility::makeInstance($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['global']['favicon']['handler']);
            /** @var HandlerInterface $faviconHandler */
            $newFrontendFavicon = $faviconHandler->process($currentFrontendFavicon);
            $GLOBALS['TSFE']->pSetup['shortcutIcon'] = $newFrontendFavicon;
        }
        return $handler->handle($request);
    }
}
