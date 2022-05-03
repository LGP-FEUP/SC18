<?php

namespace AgileBundle\Strings;

use JetBrains\PhpStorm\Pure;

/**
 * Class Strings
 * Strings utilitarian functions
 *
 * @package AgileBundle\Strings
 */
class Strings {

    /**
     * Check if the given string starts with the given substring
     *
     * @param $string
     * @param $startString
     * @return bool
     */
    #[Pure] public static function startsWith($string, $startString) : bool {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    /**
     * Check if the given string ends with the given substring
     *
     * @param $string
     * @param $endString
     * @return bool
     */
    #[Pure] public static function endsWith($string, $endString): bool {
        $len = strlen($endString);
        if ($len == 0) return true;
        return (substr($string, -$len) === $endString);
    }

}
