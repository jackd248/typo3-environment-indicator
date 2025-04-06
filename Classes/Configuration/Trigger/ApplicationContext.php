<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

use TYPO3\CMS\Core\Core\Environment;

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
