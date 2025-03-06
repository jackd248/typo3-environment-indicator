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
use TYPO3\CMS\Core\Utility\PathUtility;

class FaviconHandler
{
    public function process(string $path, ServerRequestInterface $request): string
    {
        if (!in_array(Environment::getContext()->__toString(), array_keys($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context']))
            || array_key_exists('favicon', $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]) === false) {
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
        $absolutePath = PathUtility::isAbsolutePath($path) ? $path : GeneralUtility::getFileAbsFileName($path);
        $image = $manager->read($absolutePath);

        foreach ($this->getEnvironmentImageModifiers($request) as $modifier => $configuration) {
            $modifierInstance = ImageModifyManager::makeInstance($modifier, $configuration);
            $modifierInstance->modify($image);
        }

        $image->save(GeneralHelper::getFaviconFolder() . $newImageFilename);
        return $newImagePath;
    }

    private function getEnvironmentImageModifiers(ServerRequestInterface $request): array
    {
        $configuration = isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']['*']) ?
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']['*'] : [];
        if (ApplicationType::fromRequest($request)->isFrontend()) {
            $configuration = $this->mergeConfigurationRecursiveOrdered($configuration, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']['frontend'] ?? []);
        } elseif (ApplicationType::fromRequest($request)->isBackend()) {
            $configuration = $this->mergeConfigurationRecursiveOrdered($configuration, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['favicon']['backend'] ?? []);
        }
        return $configuration;
    }

    /*
    * Can't use array_replace_recursive here, cause it keeps the order of the first array, not of the second overwriting array
    */
    private function mergeConfigurationRecursiveOrdered(array $array1, array $array2): array
    {
        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($array1[$key]) && is_array($array1[$key])) {
                $array1[$key] = $this->mergeConfigurationRecursiveOrdered($array1[$key], $value);
            } else {
                $array1[$key] = $value;
            }
        }
        return $array1;
    }

    private function generateFilename(string $originalPath, ServerRequestInterface $request): string
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
