<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractIndicator
{
    public function __construct(protected array $configuration = [], protected ?ServerRequestInterface $request = null)
    {
        $this->configuration = $this->mergeGlobalConfiguration($this->configuration);
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    protected function mergeGlobalConfiguration(array $configuration): array
    {
        $globalConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'] ?? [];
        return array_key_exists(static::class, $globalConfiguration) ? array_replace_recursive($globalConfiguration[static::class], $configuration) : $configuration;
    }
}
