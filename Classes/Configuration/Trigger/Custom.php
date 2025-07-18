<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "typo3_environment_indicator".
 *
 * Copyright (C) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

class Custom implements TriggerInterface
{
    protected \Closure|string $function;

    public function __construct(\Closure|string $function)
    {
        if ($function instanceof \Closure) {
            $this->function = $function;
            return;
        }

        if (!str_contains($function, '::')) {
            throw new \InvalidArgumentException('Function must be a callable or a valid static method string.', 1726357767);
        }

        $parts = explode('::', $function, 2);
        if (count($parts) !== 2) {
            throw new \InvalidArgumentException('Invalid static method format. Expected ClassName::methodName', 1726357767);
        }

        [$className, $methodName] = $parts;

        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\\\\]*$/', $className)) {
            throw new \InvalidArgumentException('Invalid class name format', 1726357767);
        }

        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $methodName)) {
            throw new \InvalidArgumentException('Invalid method name format', 1726357767);
        }

        if (!class_exists($className) || !method_exists($className, $methodName)) {
            throw new \InvalidArgumentException('Class or method does not exist', 1726357767);
        }

        $reflection = new \ReflectionMethod($className, $methodName);
        if (!$reflection->isStatic() || !$reflection->isPublic()) {
            throw new \InvalidArgumentException('Method must be public and static', 1726357767);
        }

        $this->function = $function;
    }

    public function check(): bool
    {
        try {
            $result = call_user_func($this->function);
            return (bool)$result;
        } catch (\Throwable $e) {
            // Log error but don't expose internal details
            error_log('Custom trigger execution failed: ' . $e->getMessage());
            return false;
        }
    }
}
