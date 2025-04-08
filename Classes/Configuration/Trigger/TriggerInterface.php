<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

interface TriggerInterface
{
    public function check(): bool;
}
