<?php

namespace ErasmusHelper\Core;

use ErasmusHelper\App;
use ErasmusHelper\Models\Faculty;
use JetBrains\PhpStorm\Pure;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class Auth {

    /**
     * Returns if the admin is connected or not
     *
     * @return bool
     */
    public function isAuth(): bool {
        if(isset($_SESSION["user_uid"])) {
            if($_SESSION["user_uid"] != null && $_SESSION["privilege_level"] >= ADMIN_PRIVILEGES)
                return true;
        }
        return false;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getAdminUID(): ?string {
        if($this->isAuth()) {
            return $_SESSION["user_uid"];
        }
        return null;
    }

    /**
     * @return string|null
     */
    #[Pure] public function getPrivilegeLevel(): ?string {
        if($this->isAuth()) {
            return $_SESSION["privilege_level"];
        }
        return null;
    }

    /**
     * @return Faculty|null
     * @throws DatabaseException
     */
    public function getFaculty(): ?Faculty {
        if($this->isAuth() && $_SESSION["faculty_id"] != null) {
            return Faculty::select(["id" => $_SESSION["faculty_id"]]);
        }
        return null;
    }

    /**
     * Disconnects the admin
     */
    public function logout(): void {
        $_SESSION["user_uid"] = null;
        $_SESSION["privilege_level"] = null;
        $_SESSION["faculty_id"] = null;
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
        $user = App::getInstance()->firebase->auth->getUser($loginResult->firebaseUserId());
        if(!empty($user->customClaims) && $user->customClaims["privilege_level"] >= ADMIN_PRIVILEGES) {
            $this->auth($user);
            return true;
        }
        return false;
    }

    /**
     * Sets the current admin connected UID as admin.
     *
     * @param UserRecord $user
     */
    private function auth(UserRecord $user): void {
        $_SESSION["user_uid"] = $user->uid;
        $_SESSION["privilege_level"] = $user->customClaims["privilege_level"];
        if($_SESSION["privilege_level"] == UNIMODERATORS_PRIVILEGES) {
            $_SESSION["faculty_id"] = $user->customClaims["faculty_id"];
        }
    }

}
