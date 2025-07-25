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

class Ip implements TriggerInterface
{
    protected array $ips;

    public function __construct(...$ip)
    {
        foreach ($ip as $ipAddress) {
            if (!$this->validateIpFormat($ipAddress)) {
                throw new \InvalidArgumentException('Invalid IP address or CIDR format: ' . $ipAddress, 1726357768);
            }
        }
        $this->ips = $ip;
    }

    public function check(): bool
    {
        $currentIp = $_SERVER['REMOTE_ADDR'] ?? ''; // @phpstan-ignore-line disallowed.variable

        if (!filter_var($currentIp, FILTER_VALIDATE_IP)) {
            return false;
        }

        foreach ($this->ips as $ip) {
            if ($this->ipMatches($currentIp, $ip)) {
                return true;
            }
        }
        return false;
    }

    /**
    * Checks if the current IP matches the given IP or CIDR range.
    *
    * @param string $currentIp The current IP address.
    * @param string $ip The IP address or CIDR range to match against.
    * @return bool True if the current IP matches, false otherwise.
    */
    protected function ipMatches(string $currentIp, string $ip): bool
    {
        if (str_contains($ip, '/')) {
            return $this->cidrMatch($currentIp, $ip);
        }
        return $currentIp === $ip;
    }

    /**
    * Checks if the current IP is within the given CIDR range.
    *
    * @param string $ip The current IP address.
    * @param string $cidr The CIDR range to match against.
    * @return bool True if the current IP is within the CIDR range, false otherwise.
    */
    protected function cidrMatch(string $ip, string $cidr): bool
    {
        $parts = explode('/', $cidr);
        if (count($parts) !== 2) {
            return false;
        }

        [$subnet, $mask] = $parts;
        $maskInt = (int)$mask;

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            if ($maskInt < 0 || $maskInt > 32) {
                return false;
            }

            $ipLong = ip2long($ip);
            $subnetLong = ip2long($subnet);

            if ($ipLong === false || $subnetLong === false) {
                return false;
            }

            $maskBits = ~((1 << (32 - $maskInt)) - 1);
            return ($ipLong & $maskBits) === ($subnetLong & $maskBits);
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            if ($maskInt < 0 || $maskInt > 128) {
                return false;
            }

            $ipBinary = inet_pton($ip);
            $subnetBinary = inet_pton($subnet);

            if ($ipBinary === false || $subnetBinary === false) {
                return false;
            }

            $maskBinary = str_repeat("\xff", (int)($maskInt / 8));
            if ($maskInt % 8 !== 0) {
                $maskBinary .= chr((0xff << (8 - ($maskInt % 8))) & 0xff);
            }
            $maskBinary = str_pad($maskBinary, 16, "\x00");

            return substr($ipBinary & $maskBinary, 0, 16) === substr($subnetBinary & $maskBinary, 0, 16);
        }

        return false;
    }

    /**
     * Validates IP address or CIDR format.
     *
     * @param string $ip The IP address or CIDR to validate.
     * @return bool True if valid, false otherwise.
     */
    protected function validateIpFormat(string $ip): bool
    {
        // Check if it's a CIDR notation
        if (str_contains($ip, '/')) {
            $parts = explode('/', $ip);
            if (count($parts) !== 2) {
                return false;
            }

            [$address, $mask] = $parts;

            // Validate mask range
            $maskInt = (int)$mask;
            if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                return $maskInt >= 0 && $maskInt <= 32;
            }

            if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                return $maskInt >= 0 && $maskInt <= 128;
            }

            return false;
        }

        // Check if it's a valid IP address
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
}
