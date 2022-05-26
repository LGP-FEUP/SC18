<?php

namespace ErasmusHelper\Core;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Country;
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
     * @return Country|null
     */
    public function getCountry(): ?Country {
        if ($this->isAuth() && $_SESSION["country_id"] != "") {
            return Country::select(["id" => $_SESSION["country_id"]]);
        }
        return null;
    }

    /**
     * @return City|null
     */
    public function getCity(): ?City {
        if ($this->isAuth() && $_SESSION["city_id"] != "") {
            return City::select(["id" => $_SESSION["city_id"]]);
        }
        return null;
    }

    /**
     * @return Faculty|null
     */
    public function getFaculty(): ?Faculty {
        if ($this->isAuth() && $_SESSION["faculty_id"] != "") {
            return Faculty::select(["id" => $_SESSION["faculty_id"]]);
        }
        return null;
    }

    /**
     * Disconnects the admin
     */
    public function logout(): void {
        $_SESSION["user_uid"] = "";
        $_SESSION["privilege_level"] = "";
        $_SESSION["city_id"] = "";
        $_SESSION["country_id"] = "";
        $_SESSION["faculty_id"] = "";
    }

    /**
     * Tries to connect the admin
     *
     * @param $mail string Mail of the admin
     * @param $password string Password of the admin
     * @return bool True if connection successful, false otherwise
     */
    public function login(string $mail, string $password): bool {
        try {
            $loginResult = App::getInstance()->firebase->auth->signInWithEmailAndPassword($mail, $password);
            $user = App::getInstance()->firebase->auth->getUser($loginResult->firebaseUserId());
            if (!empty($user->customClaims) && $user->customClaims["privilege_level"] >= ADMIN_PRIVILEGES) {
                $this->auth($user);
                return true;
            }
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
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
        $_SESSION["faculty_id"] = "";
        $_SESSION["city_id"] = "";
        $_SESSION["country_id"] = "";
        if($_SESSION["privilege_level"] == UNIMODERATORS_PRIVILEGES) {
            $_SESSION["faculty_id"] = $user->customClaims["faculty_id"];
        } else if($_SESSION["privilege_level"] == CITYMODERATORS_PRIVILEGES) {
            $_SESSION["city_id"] = $user->customClaims["city_id"];
        } else if($_SESSION["privilege_level"] == COUNTRYMODERATORS_PRIVILEGES) {
            $_SESSION["country_id"] = $user->customClaims["country_id"];
        }
    }

}
