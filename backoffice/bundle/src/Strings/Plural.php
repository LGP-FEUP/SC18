<?php

namespace AgileBundle\Strings;

/**
 * Class Plural
 * Pluralization / Singularization of english words
 *
 * @package AgileBundle\Strings
 */
class Plural {

    /**
     * Plurals pattern array
     *
     * @const array
     */
    const PLURALS = [
        '/(quiz)$/i'               => "$1zes",
        '/^(ox)$/i'                => "$1en",
        '/([m|l])ouse$/i'          => "$1ice",
        '/(matr|vert|ind)ix|ex$/i' => "$1ices",
        '/(x|ch|ss|sh)$/i'         => "$1es",
        '/([^aeiouy]|qu)y$/i'      => "$1ies",
        '/(hive)$/i'               => "$1s",
        '/(?:([^f])fe|([lr])f)$/i' => "$1$2ves",
        '/(shea|lea|loa|thie)f$/i' => "$1ves",
        '/sis$/i'                  => "ses",
        '/([ti])um$/i'             => "$1a",
        '/(tomat|potat|ech|her|vet)o$/i'=> "$1oes",
        '/(bu)s$/i'                => "$1ses",
        '/(alias)$/i'              => "$1es",
        '/(octop)us$/i'            => "$1i",
        '/(ax|test)is$/i'          => "$1es",
        '/(us)$/i'                 => "$1es",
        '/s$/i'                    => "s",
        '/$/'                      => "s"
    ];

    /**
     * Singulars pattern array
     *
     * @const array
     */
    const SINGULARS = [
        '/(quiz)zes$/i'             => "$1",
        '/(matr)ices$/i'            => "$1ix",
        '/(vert|ind)ices$/i'        => "$1ex",
        '/^(ox)en$/i'               => "$1",
        '/(alias)es$/i'             => "$1",
        '/(octop|vir)i$/i'          => "$1us",
        '/(cris|ax|test)es$/i'      => "$1is",
        '/(shoe)s$/i'               => "$1",
        '/(o)es$/i'                 => "$1",
        '/(bus)es$/i'               => "$1",
        '/([m|l])ice$/i'            => "$1ouse",
        '/(x|ch|ss|sh)es$/i'        => "$1",
        '/(m)ovies$/i'              => "$1ovie",
        '/(s)eries$/i'              => "$1eries",
        '/([^aeiouy]|qu)ies$/i'     => "$1y",
        '/([lr])ves$/i'             => "$1f",
        '/(tive)s$/i'               => "$1",
        '/(hive)s$/i'               => "$1",
        '/(li|wi|kni)ves$/i'        => "$1fe",
        '/(shea|loa|lea|thie)ves$/i'=> "$1f",
        '/(^analy)ses$/i'           => "$1sis",
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i'  => "$1$2sis",
        '/([ti])a$/i'               => "$1um",
        '/(n)ews$/i'                => "$1ews",
        '/(h|bl)ouses$/i'           => "$1ouse",
        '/(corpse)s$/i'             => "$1",
        '/(us)es$/i'                => "$1",
        '/s$/i'                     => ""
    ];

    /**
     * Irregulars english words
     *
     * @const array
     */
    const IRREGULARS = [
        'move'   => 'moves',
        'foot'   => 'feet',
        'goose'  => 'geese',
        'sex'    => 'sexes',
        'child'  => 'children',
        'man'    => 'men',
        'tooth'  => 'teeth',
        'person' => 'people'
    ];

    /**
     * Uncountable english words
     *
     * @const array
     */
    const UNCOUNTABLE = [
        'sheep',
        'fish',
        'deer',
        'series',
        'species',
        'money',
        'rice',
        'information',
        'equipment'
    ];

    /**
     * Try to pluralize the given string
     *
     * @param $string
     * @return array|string|null
     */
    public static function pluralize($string): array|string|null {
        // Save some time in the case that singular and plural are the same
        if (in_array(strtolower($string), static::UNCOUNTABLE)) return $string;

        // Check for irregular singular forms
        foreach (static::IRREGULARS as $pattern => $result)  {
            $pattern = '/' . $pattern . '$/i';
            if (preg_match($pattern, $string)) return preg_replace($pattern, $result, $string);
        }

        // Check for matches using regular expressions
        foreach (static::PLURALS as $pattern => $result) {
            if (preg_match($pattern, $string)) return preg_replace($pattern, $result, $string);
        }

        return $string;
    }

    /**
     * Try to singularize the given string
     *
     * @param $string
     * @return array|string|null
     */
    public static function singularize($string): array|string|null {
        // Save some time in the case that singular and plural are the same
        if (in_array(strtolower($string), self::UNCOUNTABLE)) return $string;

        // Check for irregular plural forms
        foreach (static::IRREGULARS as $result => $pattern) {
            $pattern = '/' . $pattern . '$/i';
            if ( preg_match( $pattern, $string ) ) return preg_replace( $pattern, $result, $string);
        }

        // Check for matches using regular expressions
        foreach (static::SINGULARS as $pattern => $result)  {
            if (preg_match( $pattern, $string)) return preg_replace($pattern, $result, $string);
        }

        return $string;
    }

    /**
     * Pluralize the string if count > 1
     *
     * @param $count
     * @param $string
     * @return string
     */
    public static function pluralizeIf($count, $string): string {
        return $count <= 1 ? $string : self::pluralize($string);
    }

}
