<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

interface HandlerInterface
{
    public function process(string $path): string;

    public function shouldProcess(): bool;
}
