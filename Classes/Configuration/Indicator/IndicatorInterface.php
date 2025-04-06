<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;

interface IndicatorInterface
{
    public function getConfiguration(): array;
}
