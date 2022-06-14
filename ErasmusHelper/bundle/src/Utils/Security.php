<?php

namespace AgileBundle\Utils;

use JetBrains\PhpStorm\Pure;

/**
 * Class Security
 * Basic security operations
 *
 * @package AgileBundle\Utils
 */
class Security {

    /**
     * Generates n random digits
     *
     * @param $digits
     * @return int
     */
    #[Pure]
    public static function generateRandomDigits($digits): int {
        return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
    }

    /**
     * Retrieves the current ipAddress of the consumer
     *
     * @return string|null
     */
    public static function getIpAddress(): string|null {
        // Check for shared Internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && static::checkIpAddress($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // Check for IP addresses passing through proxies
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

            // Check if multiple IP addresses exist in var
            if (str_contains($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
                $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($ipList as $ip) {
                    if (static::checkIpAddress($ip)) {
                        return $ip;
                    }
                }
            } else {
                if (static::checkIpAddress($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
            }
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED']) && static::checkIpAddress($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }
        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && static::checkIpAddress($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && static::checkIpAddress($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }
        if (!empty($_SERVER['HTTP_FORWARDED']) && static::checkIpAddress($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        }

        // Return unreliable IP address since all else failed
        if (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }

        return null;
    }

    /**
     * Ensures an IP address is both a valid IP address and does not fall within
     * a private network range.
     *
     * @param string $ip
     * @param array $whitelist
     * @param array $blacklist
     * @param bool $allowPrivate
     * @return bool
     */
    public static function checkIpAddress(string $ip, array $whitelist = [], array $blacklist = [], bool $allowPrivate = true): bool {
        // First we check if the ip is not unknown
        if (strtolower($ip) === 'unknown') return false;
        // Then if the ip is not blacklisted or if is the ip is not a string
        if (!is_string($ip) || in_array($ip, $blacklist)) return false;
        // Then if the ip is in whitelist
        if (in_array($ip, $whitelist)) return true;

        // Then we check if the ip is private
        $filterFlag = FILTER_FLAG_NO_RES_RANGE;
        if (!$allowPrivate) {
            if (preg_match('/^127\.$/', $ip)) {
                return false;
            }
            $filterFlag |= FILTER_FLAG_NO_PRIV_RANGE;
        }

        // And finally we filter_var with FILTER_VALIDATE_IP
        if (!filter_var($ip, FILTER_VALIDATE_IP, $filterFlag)) return false;
        return true;
    }

}
