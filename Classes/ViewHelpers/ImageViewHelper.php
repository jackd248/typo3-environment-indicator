<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "typo3_environment_indicator".
 *
 * Copyright (C) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\ViewHelpers;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Image;
use KonradMichalik\Typo3EnvironmentIndicator\Image\FrontendImageHandler;
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
    ) {}

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('_path', 'string', 'Image path');
    }

    public function render(): string
    {
        $request = $this->renderingContext->hasAttribute(ServerRequestInterface::class) ? $this->renderingContext->getAttribute(ServerRequestInterface::class) : $GLOBALS['TYPO3_REQUEST'];
        $image = $this->renderChildren();

        $extensionConfig = $this->extensionConfiguration->get(Configuration::EXT_KEY);
        if ((bool)($extensionConfig['frontend']['image'] ?? false) !== true ||
            !GeneralHelper::isCurrentIndicator(Image::class)
        ) {
            return $image;
        }

        if (!PathUtility::isExtensionPath($image)) {
            $image = Environment::getPublicPath() . (str_contains($image, '?') ? strtok($image, '?') : $image);
        }
        return GeneralUtility::makeInstance(FrontendImageHandler::class)->process($image, $request);
    }
}
