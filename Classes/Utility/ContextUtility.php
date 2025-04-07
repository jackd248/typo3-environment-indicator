<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Hint;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        return explode(' ', $this->getFrontendHintConfiguration()['position'])[0] . ':0';
    }

    public function getPositionY(): string
    {
        return explode(' ', $this->getFrontendHintConfiguration()['position'])[1] . ':0';
    }

    public function getTitle(): string
    {
        $title = $this->getFrontendHintConfiguration()['text'] ?? null;
        if ($title !== null) {
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
