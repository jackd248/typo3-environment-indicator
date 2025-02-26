<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Middleware;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Service\FaviconHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FrontendFaviconMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $typo3Version = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();
        if ($this->extensionConfiguration->get(Configuration::EXT_KEY)['frontend']['favicon']) {
            if ($typo3Version < 13 &&
                is_array($GLOBALS['TSFE']->pSetup) &&
                array_key_exists('shortcutIcon', $GLOBALS['TSFE']->pSetup) &&
                $GLOBALS['TSFE']->pSetup['shortcutIcon'] !== ''
            ) {
                $currentFrontendFavicon = $GLOBALS['TSFE']->pSetup['shortcutIcon'];
                $faviconHandler = GeneralUtility::makeInstance(FaviconHandler::class);
                $newFrontendFavicon = $faviconHandler->process($currentFrontendFavicon, $request);
                $GLOBALS['TSFE']->pSetup['shortcutIcon'] = $newFrontendFavicon;
            } elseif ($typo3Version >= 13
            ) {
                $typoScript = $request->getAttribute('frontend.typoscript');
                if ($typoScript->hasPage() && array_key_exists('shortcutIcon', $typoScript->getPageArray()) && $typoScript->getPageArray()['shortcutIcon'] !== '') {
                    $typoScriptPageArray = $typoScript->getPageArray();
                    $currentFrontendFavicon = $typoScriptPageArray['shortcutIcon'];
                    $faviconHandler = GeneralUtility::makeInstance(FaviconHandler::class);
                    $newFrontendFavicon = $faviconHandler->process($currentFrontendFavicon, $request);
                    $typoScriptPageArray['shortcutIcon'] = $newFrontendFavicon;
                    $typoScript->setPageArray($typoScriptPageArray);
                }
            }
        }

        return $handler->handle($request);
    }
}
