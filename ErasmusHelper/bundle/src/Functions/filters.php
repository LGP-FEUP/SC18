<?php

use JetBrains\PhpStorm\Pure;

#[Pure] function filterStrictPositiveFloat($float): ?float {
    return floatval($float) > 0 ? floatval($float) : null;
}

#[Pure] function filterStrictPositiveInt($int): ?int {
    return intval($int) > 0 ? intval($int) : null;
}

#[Pure] function filterPositiveInt($int): ?int {
    return intval($int) >= 0 ? intval($int) : null;
}

#[Pure] function filterPositiveFloat($float): ?float {
    return floatval($float) >= 0 ? floatval($float) : null;
}

function filterDate($date): ?DateTime {
    if($date instanceof DateTime){
        return $date;
    } else if(is_int($date)){
        try {
            return new DateTime($date);
        } catch (Exception $e) {
            return null;
        }
    } else if(is_string($date)){
        return create_date_from_standards($date);
    }
    return null;
}

function filterIp($ip){
    if(checkIpAddress($ip)){
        return $ip;
    }
    return null;
}

#[Pure] function filterString($string): ?string {
    if(!empty((string)$string)){
        return strval($string);
    }
    return null;
}

function filterZipcode($string) : ?string {
    if(preg_match("/^[0-9]{5}$/", $string)){
        return strval($string);
    }
    return null;
}

function filterCountry($string) :?string {
    if(preg_match('/^[A-Z]{2}$/',$string)){
        return strval($string);
    }
    return null;
}

#[Pure] function filterUrl($url): ?string {
    if(filter_var($url, FILTER_VALIDATE_URL) !== false){
        return strval($url);
    }
    return null;
}
