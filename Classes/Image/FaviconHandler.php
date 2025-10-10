<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\{Favicon, IndicatorInterface};
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * FaviconHandler.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class FaviconHandler extends AbstractImageHandler
{
    public function __construct(?IndicatorInterface $indicator = null)
    {
        $indicator = $indicator ?? GeneralUtility::makeInstance(Favicon::class);
        parent::__construct($indicator);
    }
}
