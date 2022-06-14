<?php

namespace ErasmusHelper;

use AgileBundle\Utils\Dbg;
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
     */
    public static function UUIDGenerator(): string {
        try {
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        } catch (Exception $e) {
            Dbg::error($e->getMessage());
            return "";
        }
    }

    public static function getPrivilegeName(int $privilege): string {
        if($privilege == ADMIN_PRIVILEGES) {
            return "Admin";
        } else if ($privilege == UNIMODERATORS_PRIVILEGES) {
            return "Uni Moderator";
        } else if ($privilege == CITYMODERATORS_PRIVILEGES) {
            return "City Moderator";
        } else if ($privilege == COUNTRYMODERATORS_PRIVILEGES) {
            return "Country Moderator";
        } else {
            return "None";
        }
    }

    public static function getInstance(): App {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }
}