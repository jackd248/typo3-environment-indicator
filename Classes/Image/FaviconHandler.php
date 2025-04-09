<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Favicon;

class FaviconHandler extends AbstractImageHandler
{
    public function __construct()
    {
        parent::__construct(new Favicon());
    }
}
