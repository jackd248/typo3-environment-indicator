<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\ViewHelpers;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Image;
use KonradMichalik\Typo3EnvironmentIndicator\Service\FrontendImageHandler;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
* Image ViewHelper
*
* This ViewHelper processes the given image regarding the application context.
*
* Usages:
* ::
*    <html xmlns:env="http://typo3.org/ns/KonradMichalik/Typo3EnvironmentIndicator/ViewHelpers" data-namespace-typo3-fluid="true">
*
*     {f:uri.resource(path:'EXT:your_extension/Resources/Public/Images/Default.png') -> env:image()}
*     {env:image(path:'EXT:your_extension/Resources/Public/Images/Default.png')}
*/
class ImageViewHelper extends AbstractViewHelper
{
    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration
    ) {
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('_path', 'string', 'Image path');
    }

    public function render(): string
    {
        $request = $this->renderingContext->hasAttribute(ServerRequestInterface::class) ? $this->renderingContext->getAttribute(ServerRequestInterface::class) : $GLOBALS['TYPO3_REQUEST'];
        $image = $this->renderChildren();

        if (!$this->extensionConfiguration->get(Configuration::EXT_KEY)['frontend']['image']
            || !GeneralHelper::isCurrentIndicator(Image::class)
        ) {
            return $image;
        }

        if (!PathUtility::isExtensionPath($image)) {
            $image = Environment::getPublicPath() . (str_contains($image, '?') ? strtok($image, '?') : $image);
        }
        return GeneralUtility::makeInstance(FrontendImageHandler::class)->process($image, $request);
    }
}
