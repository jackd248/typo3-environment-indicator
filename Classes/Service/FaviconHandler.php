<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FaviconHandler
{
    public function process(string $path): string
    {
        $newImageFilename = $this->generateFilename($path) . '.png';
        $newImagePath = GeneralHelper::getFaviconFolder(false) . $newImageFilename;

        if ($path === $newImagePath) {
            return $newImagePath;
        }

        $manager = new ImageManager(
            new Driver()
        );
        $image = $manager->read(GeneralUtility::getFileAbsFileName($path));

        foreach ($this->getEnvironmentImageModifiers() as $modifier => $configuration) {
            $modifierInstance = ImageModifyManager::makeInstance($modifier, $configuration);
            $modifierInstance->modify($image);
        }

        $image->save(GeneralHelper::getFaviconFolder() . $newImageFilename);
        return $newImagePath;
    }

    public function getEnvironmentImageModifiers(): array
    {
        return isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']) ?
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon'] : [];
    }

    public function generateFilename(string $originalPath): string
    {
        $parts = [
            $originalPath,
            Environment::getContext()->__toString(),
        ];
        foreach ($this->getEnvironmentImageModifiers() as $modifier => $configuration) {
            $parts[] = $modifier;
            $parts[] = json_encode($configuration);
        }
        return md5(implode('_', $parts));
    }
}
