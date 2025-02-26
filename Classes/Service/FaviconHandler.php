<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FaviconHandler
{
    public function process(string $path, ServerRequestInterface $request): string
    {
        if (!in_array(Environment::getContext()->__toString(), array_keys($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context']))) {
            return $path;
        }

        $newImageFilename = $this->generateFilename($path, $request) . '.png';
        $newImagePath = GeneralHelper::getFaviconFolder(false) . $newImageFilename;

        if ($path === $newImagePath) {
            return $newImagePath;
        }

        $manager = new ImageManager(
            new Driver()
        );
        $image = $manager->read(GeneralUtility::getFileAbsFileName($path));

        foreach ($this->getEnvironmentImageModifiers($request) as $modifier => $configuration) {
            $modifierInstance = ImageModifyManager::makeInstance($modifier, $configuration);
            $modifierInstance->modify($image);
        }

        $image->save(GeneralHelper::getFaviconFolder() . $newImageFilename);
        return $newImagePath;
    }

    public function getEnvironmentImageModifiers(ServerRequestInterface $request): array
    {
        $configuration = isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']) ?
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon'] : [];
        if (ApplicationType::fromRequest($request)->isFrontend()) {
            $configuration = array_replace_recursive($configuration, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['frontendFavicon'] ?? []);
        } elseif (ApplicationType::fromRequest($request)->isBackend()) {
            $configuration = array_replace_recursive($configuration, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backendFavicon'] ?? []);
        }
        return $configuration;
    }

    public function generateFilename(string $originalPath, ServerRequestInterface $request): string
    {
        $parts = [
            $originalPath,
            Environment::getContext()->__toString(),
        ];
        foreach ($this->getEnvironmentImageModifiers($request) as $modifier => $configuration) {
            $parts[] = $modifier;
            $parts[] = json_encode($configuration);
        }
        return md5(implode('_', $parts));
    }
}
