<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Image\ModifierInterface;
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
            array_merge(self::getGlobalConfiguration()['favicon']['defaults'][$modifierClass], $configuration)
        );
    }

    public static function getGlobalConfiguration(): array
    {
        return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['global'];
    }
}
