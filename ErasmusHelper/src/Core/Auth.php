<?php

namespace ErasmusHelper\Core;

use ErasmusHelper\App;
use JetBrains\PhpStorm\Pure;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class Auth {

    /**
     * Returns if the admin is connected or not
     *
     * @return bool
     */
    public function isAuth(): bool {
        if(isset($_SESSION["admin_uid"])) {
            if($_SESSION["admin_uid"] != null && $_SESSION["privilegeLevel"] >= 1)
                return true;
        }
        return false;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getAdminUID(): ?string {
        if($this->isAuth()) {
            return $_SESSION["admin_uid"];
        }
        return null;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getPrivilegeLevel(): ?string {
        if($this->isAuth()) {
            return $_SESSION["privilegeLevel"];
        }
        return null;
    }

    /**
     * Disconnects the admin
     */
    public function logout() {
        $_SESSION["admin_uid"] = null;
    }

    /**
     * Tries to connect the admin
     *
     * @param $mail string Mail of the admin
     * @param $password string Password of the admin
     * @return bool True if connection successful, false otherwise
     * @throws AuthException
     * @throws FirebaseException
     */
    public function login(string $mail, string $password): bool {
        $loginResult = App::getInstance()->firebase->auth->signInWithEmailAndPassword($mail, $password);
        $admin = App::getInstance()->firebase->auth->getUser($loginResult->firebaseUserId());
        if(!empty($admin->customClaims) && $admin->customClaims["privilege_level"] >= 1) {
            $this->auth($admin->uid, $admin->customClaims["privilege_level"]);
            return true;
        }
        return false;
    }

    /**
     * Sets the current admin connected UID as admin.
     *
     * @param string $adminUID
     */
    private function auth(string $adminUID, int $privilegeLevel) {
        $_SESSION["admin_uid"] = $adminUID;
        $_SESSION["privilegeLevel"] = $privilegeLevel;
    }

}
