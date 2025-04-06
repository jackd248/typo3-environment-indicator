<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;

class AbstractModifier
{
    protected array $configuration = [];

    public function __construct(array $configuration)
    {
        $this->mergeGlobalConfiguration($configuration);
        $this->verifyRequiredArrayKeys($configuration);
        $this->configuration = $configuration;
    }

    public function getRequiredConfigurationKeys(): array
    {
        return [];
    }

    protected function verifyRequiredArrayKeys(array $configuration): void
    {
        $missingKeys = array_diff($this->getRequiredConfigurationKeys(), array_keys($configuration));
        if (!empty($missingKeys)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Missing required configuration keys for %s: %s',
                    static::class,
                    implode(', ', $missingKeys)
                ),
                1740401564
            );
        }
    }

    protected function mergeGlobalConfiguration(array &$configuration): void
    {
        $globalConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'][static::class] ?? [];
        $configuration = array_replace_recursive($globalConfiguration, $configuration);
    }
}
