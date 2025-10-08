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

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Logo;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\IndicatorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * BackendLogoHandler.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class BackendLogoHandler extends AbstractImageHandler
{
    public function __construct(?IndicatorInterface $indicator = null)
    {
        $indicator = $indicator ?? GeneralUtility::makeInstance(Logo::class);
        parent::__construct($indicator);
    }
}
