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

namespace KonradMichalik\Typo3EnvironmentIndicator\Image\Modifier;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\ImageDriverUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function is_string;

/**
 * ReplaceModifier.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class ReplaceModifier extends AbstractModifier implements ModifierInterface
{
    public function modify(ImageInterface &$image): void
    {
        $manager = new ImageManager(
            ImageDriverUtility::resolveDriver(),
        );
        $image = $manager->read(GeneralUtility::getFileAbsFileName($this->configuration['path']));
    }

    public function validateConfiguration(array $configuration): bool
    {
        if (!isset($configuration['path']) || !is_string($configuration['path'])) {
            return false;
        }

        return true;
    }
}
