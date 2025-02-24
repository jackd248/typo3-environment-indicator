<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Enum;

enum FaviconType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case BORDER = 'border';
}
