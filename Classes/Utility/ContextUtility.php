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
        return explode(' ', $this->getFrontendHintConfiguration()['position'] ?? 'left top')[0] . ':0';
    }

    public function getPositionY(): string
    {
        return explode(' ', $this->getFrontendHintConfiguration()['position'] ?? 'left top')[1] . ':0';
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
