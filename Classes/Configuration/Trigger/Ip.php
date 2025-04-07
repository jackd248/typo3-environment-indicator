<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

class Ip implements TriggerInterface
{
    protected array $ips;

    public function __construct(...$ip)
    {
        $this->ips = $ip;
    }

    public function check(): bool
    {
        $currentIp = $_SERVER['REMOTE_ADDR'];
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
        if (strpos($ip, '/') !== false) {
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
        list($subnet, $mask) = explode('/', $cidr);
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $ip = ip2long($ip);
            $subnet = ip2long($subnet);
            $mask = (int)$mask;
            $mask = ~((1 << (32 - $mask)) - 1);
            return ($ip & $mask) === ($subnet & $mask);
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ip = inet_pton($ip);
            $subnet = inet_pton($subnet);
            if ($ip === false || $subnet === false) {
                return false;
            }
            $mask = (int)$mask;
            $mask = str_repeat('f', $mask / 4) . str_repeat('0', 32 - $mask / 4);
            $mask = pack('H*', $mask);
            return ($ip & $mask) === ($subnet & $mask);
        }
        return false;
    }
}
