<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Image;

class FrontendImageHandler extends AbstractImageHandler
{
    public function __construct()
    {
        parent::__construct(new Image());
    }
}
