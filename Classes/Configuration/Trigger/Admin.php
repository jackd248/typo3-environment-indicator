<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

class Admin implements TriggerInterface
{
    public function check(): bool
    {
        return isset($GLOBALS['BE_USER']) && $GLOBALS['BE_USER']->isAdmin();
    }
}
