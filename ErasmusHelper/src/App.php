<?php

namespace ErasmusHelper;

use ErasmusHelper\Controllers\AuthController;
use ErasmusHelper\Core\Auth;
use ErasmusHelper\Core\DBConf;
use Exception;

class App {

    private static $_instance = null;

    public AuthController $authController;
    public Auth $auth;
    public DBConf $firebase;

    private function __construct() {
        $this->authController = new AuthController();
        $this->auth = new Auth();
        $this->firebase = new DBConf();
        //Init singletons
    }

    /**
     * Generates a v4 UUID.
     *
     * @return string
     * @throws Exception
     */
    public static function UUIDGenerator(): string {
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
    }

    public static function getInstance(): App {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }
}