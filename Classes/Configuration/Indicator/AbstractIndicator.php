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

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use Psr\Http\Message\ServerRequestInterface;

use function array_key_exists;
use function is_array;

/**
 * AbstractIndicator.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
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

        return is_array($globalConfiguration) && array_key_exists(static::class, $globalConfiguration) ? array_replace_recursive($globalConfiguration[static::class], $configuration) : $configuration;
    }
}
