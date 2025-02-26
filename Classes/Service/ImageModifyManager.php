<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Image\ModifierInterface;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ImageModifyManager
{
    public static function makeInstance(string $modifierClass, array $configuration = []): ModifierInterface
    {
        if (!class_exists($modifierClass)) {
            throw new \RuntimeException('Modifier class "' . $modifierClass . '" does not exist', 1740401911);
        }
        return GeneralUtility::makeInstance(
            $modifierClass,
            array_key_exists($modifierClass, GeneralHelper::getGlobalConfiguration()['favicon']['defaults']) ? array_merge(GeneralHelper::getGlobalConfiguration()['favicon']['defaults'][$modifierClass], $configuration) : $configuration
        );
    }
}
