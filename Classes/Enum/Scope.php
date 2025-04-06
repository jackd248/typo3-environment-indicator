<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Enum;

enum Scope: string
{
    case Both = 'both';
    case Frontend = 'frontend';
    case Backend = 'backend';
    case Global = 'global';
}
