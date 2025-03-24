<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

enum HandlerType: string
{
    case Favicon = 'favicon';
    case Image = 'image';
}
