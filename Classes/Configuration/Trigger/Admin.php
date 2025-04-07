<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

class Admin implements TriggerInterface
{
    public function __construct()
    {
    }

    public function check(): bool
    {
        return $GLOBALS['BE_USER']->isAdmin();
    }
}
