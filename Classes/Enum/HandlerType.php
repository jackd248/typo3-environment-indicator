<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Enum;

enum HandlerType: string
{
    case Favicon = 'favicon';
    case Image = 'image';
    case Logo = 'logo';
}
