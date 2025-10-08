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
use KonradMichalik\Typo3EnvironmentIndicator\Image\FaviconHandler;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function array_key_exists;
use function is_array;

/**
 * FrontendFaviconMiddleware.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class FrontendFaviconMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->isFeatureEnabled()) {
            return $handler->handle($request);
        }

        $typo3Version = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();

        if ($typo3Version < 13
            && is_array($GLOBALS['TSFE']->pSetup)
            && array_key_exists('shortcutIcon', $GLOBALS['TSFE']->pSetup)
            && '' !== $GLOBALS['TSFE']->pSetup['shortcutIcon']
        ) {
            $currentFrontendFavicon = $GLOBALS['TSFE']->pSetup['shortcutIcon'];
            $faviconHandler = GeneralUtility::makeInstance(FaviconHandler::class);
            $newFrontendFavicon = $faviconHandler->process($currentFrontendFavicon, $request);
            $GLOBALS['TSFE']->pSetup['shortcutIcon'] = $newFrontendFavicon;
        } elseif ($typo3Version >= 13) {
            $typoScript = $request->getAttribute('frontend.typoscript');
            if ($typoScript->hasPage() && array_key_exists('shortcutIcon', $typoScript->getPageArray()) && '' !== $typoScript->getPageArray()['shortcutIcon']) {
                $typoScriptPageArray = $typoScript->getPageArray();
                $currentFrontendFavicon = $typoScriptPageArray['shortcutIcon'];
                $faviconHandler = GeneralUtility::makeInstance(FaviconHandler::class);
                $newFrontendFavicon = $faviconHandler->process($currentFrontendFavicon, $request);
                $typoScriptPageArray['shortcutIcon'] = $newFrontendFavicon;
                $typoScript->setPageArray($typoScriptPageArray);
            }
        }

        return $handler->handle($request);
    }

    private function isFeatureEnabled(): bool
    {
        $extensionConfig = $this->extensionConfiguration->get(Configuration::EXT_KEY);

        return true === (bool) ($extensionConfig['frontend']['favicon'] ?? false);
    }
}
