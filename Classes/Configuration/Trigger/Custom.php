<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

class Custom implements TriggerInterface
{
    protected $function;

    public function __construct($function)
    {
        if (!is_callable($function) && !(is_string($function) && strpos($function, '::') !== false)) {
            throw new \InvalidArgumentException('Function must be a callable or a valid static method string.', 1726357767);
        }
        $this->function = $function;
    }

    public function check(): bool
    {
        return call_user_func($this->function);
    }
}
