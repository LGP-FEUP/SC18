<?php

namespace AgileBundle\Utils;

use JetBrains\PhpStorm\Pure;

/**
 * Class Request
 * Basic http request utility
 *
 * @package AgileBundle\Utils
 */
class Request {

    /**
     * Retrieves a POST variable if set, else returns default
     *
     * @param $k
     * @param null $default
     * @return mixed
     */
    public static function valuePost($k, $default = null): mixed {
        if(empty($_POST)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        return $_POST[$k] ?? $default;
    }

    /**
     * Retrieves a REQUEST variable if set, else returns default
     *
     * @param $k
     * @param null $default
     * @return mixed
     */
    #[Pure]
    public static function valueRequest($k, $default = null): mixed {
        return $_REQUEST[$k] ?? $default;
    }

    /**
     * Retrieves a SESSION variable if set, else returns default
     *
     * @param $k
     * @param null $default
     * @return mixed
     */
    #[Pure]
    public static function valueSession($k, $default = null): mixed {
        return $_SERVER[$k] ?? $default;
    }

    /**
     * Get access token from header given header format (default Bearer)
     *
     * @param string $keyName
     * @return string|null
     */
    public static function getBearerHeader($keyName = 'Bearer'): ?string {
        $headers = static::getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/' . $keyName . '\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    /**
     * Returns the authorization header content
     *
     * @return string|null
     */
    private static function getAuthorizationHeader(): ?string {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else {
            if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
        }
        return $headers;
    }

}
