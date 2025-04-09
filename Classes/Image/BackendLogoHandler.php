<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Image;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Logo;

class BackendLogoHandler extends AbstractImageHandler
{
    public function __construct()
    {
        parent::__construct(new Logo());
    }
}
