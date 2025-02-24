<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

class AbstractModifier
{
    protected array $configuration = [];

    public function __construct(array $configuration)
    {
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
                    'Missing required configuration keys: %s',
                    implode(', ', $missingKeys)
                ),
                1740401564
            );
        }
    }
}
