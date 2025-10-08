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

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Hint;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function array_key_exists;

/**
 * ContextUtility.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class ContextUtility
{
    public function getContext(): string
    {
        return Environment::getContext()->__toString();
    }

    public function getColor(): string
    {
        return $this->getFrontendHintConfiguration()['color'] ?? 'transparent';
    }

    public function getTextColor(): string
    {
        return ColorUtility::getOptimalTextColor($this->getFrontendHintConfiguration()['color'] ?? 'transparent');
    }

    public function getPositionX(): string
    {
        return explode(' ', $this->getFrontendHintConfiguration()['position'] ?? 'left top')[0].':0';
    }

    public function getPositionY(): string
    {
        return explode(' ', $this->getFrontendHintConfiguration()['position'] ?? 'left top')[1].':0';
    }

    public function getTitle(): string
    {
        $title = $this->getFrontendHintConfiguration()['text'] ?? null;
        if (null !== $title) {
            return $title;
        }
        // Deprecated: $GLOBALS['TSFE'] is deprecated since TYPO3 v13.
        $pid = $GLOBALS['TSFE']->id;
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        $site = $siteFinder->getSiteByPageId($pid);

        return array_key_exists('websiteTitle', $site->getConfiguration()) ? $site->getConfiguration()['websiteTitle'] : $site->getIdentifier();
    }

    private function getFrontendHintConfiguration(): array
    {
        return GeneralHelper::getIndicatorConfiguration()[Hint::class] ?? [];
    }
}
