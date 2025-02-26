<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\ViewHelpers;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Service\FaviconHandler;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
* Favicon ViewHelper
*
* This ViewHelper processes the given favicon regarding the application context.
*
* Usages:
* ::
*    <html xmlns:env="http://typo3.org/ns/KonradMichalik/Typo3EnvironmentIndicator/ViewHelpers" data-namespace-typo3-fluid="true">
*
*     {f:uri.resource(path:'EXT:your_extension/Resources/Public/Favicon/favicon.png') -> env:favicon()}
*     {env:favicon(favicon:'EXT:your_extension/Resources/Public/Favicon/favicon.png')}
*/
class FaviconViewHelper extends AbstractViewHelper
{
    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration
    ) {
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('favicon', 'string', 'Favicon path');
    }

    public function render(): string
    {
        // get request
        $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        $applicationType = ApplicationType::fromRequest($request);

        if (!$this->extensionConfiguration->get(Configuration::EXT_KEY)[$applicationType->value]['favicon']) {
            return '';
        }

        $favicon = $this->renderChildren();

        if (!PathUtility::isExtensionPath($favicon)) {
            $favicon = Environment::getPublicPath() . (str_contains($favicon, '?') ? strtok($favicon, '?') : $favicon);
        }
        $handler = GeneralUtility::makeInstance(FaviconHandler::class);
        return $handler->process($favicon, $request);
    }
}
