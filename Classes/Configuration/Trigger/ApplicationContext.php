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

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

use TYPO3\CMS\Core\Core\Environment;

/**
 * ApplicationContext.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class ApplicationContext implements TriggerInterface
{
    protected array $contexts;

    public function __construct(...$context)
    {
        $this->contexts = $context;
    }

    public function check(): bool
    {
        $currentApplicationContext = Environment::getContext()->__toString();
        foreach ($this->contexts as $context) {
            if (fnmatch($context, $currentApplicationContext)) {
                return true;
            }
        }

        return false;
    }
}
