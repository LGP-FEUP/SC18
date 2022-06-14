<?php

namespace ErasmusHelper\Models;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\App;
use ErasmusHelper\Core\DBConf;
use JetBrains\PhpStorm\ArrayShape;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

abstract class StaffModel {

    public const PRIVILEGE_LEVEL = 0;

    const CLAIMS = [];

    public string $id = "";
    public string $email = "";
    public int $privilege_level = 0;
    public bool $disabled = false;
    public bool $dbStored = false;

    /**
     * Constructs an object. If it comes from database (= $date is nul null), hydrates it.
     * Otherwise, generates a new UUID for this object.
     */
    public function __construct(UserRecord $user = null) {
        if($user != null) {
            $this->hydrate($user);
        }
    }

    /**
     * Hydrates a staff member with corresponding claims.
     *
     * @param UserRecord $user
     * @return void
     */
    protected function hydrate(UserRecord $user): void {
        $this->dbStored = true;
        $this->id = $user->uid;
        $this->disabled = $user->disabled;
        $this->email = $user->email;
        foreach (static::CLAIMS as $claim) {
            $this->$claim = $user->customClaims[$claim];
        }
        $this->privilege_level = $user->customClaims["privilege_level"];
    }

    /**
     * Updates a staff member's information to the db.
     *
     * @param array|null $create
     * @return bool
     */
    public function save(array $create = null): bool {
        try {
            if($create != null) {
                App::getInstance()->firebase->auth->updateUser($this->id, $create);
            } else {
                App::getInstance()->firebase->auth->updateUser($this->id, $this->serialize());
            }
            return true;
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
            return false;
        }
    }

    /**
     * Updates the ability of a staff member.
     *
     * @return bool
     */
    public function changeAbility(): bool {
        if($this->disabled) {
            $this->disabled = false;
        } else {
            $this->disabled = true;
        }
        return $this->save();
    }

    /**
     * Serializes the object to be saved into the Auth system.
     *
     * @return array
     */
    #[ArrayShape(["uid" => "string", "email" => "string", "disabled" => "bool"])]
    protected function serialize(): array{
        return array(
            "uid" => $this->id,
            "email" => $this->email,
            "disabled" => $this->disabled,
        );
    }

    /**
     * Returns if an object is currently in the database or not.
     *
     * @return bool
     */
    public function exists(): bool {
        return $this->dbStored;
    }

    /**
     * Get a staff member by its ID.
     *
     * @param string $id UID of an auth user.
     * @return mixed
     */
    public static function getById(string $id): mixed {
        try {
            $userRecord = App::getInstance()->firebase->auth->getUser($id);
            if ($userRecord->customClaims["privilege_level"] == static::PRIVILEGE_LEVEL) {
                return DBConf::instantiateAuth(static::class, $userRecord);
            }
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
        }
        return null;
    }

    public static function getAll(): ?array {
        try {
            $all = App::getInstance()->firebase->auth->listUsers();
            $toReturn = array();
            foreach ($all as $user) {
                if (!empty($user->customClaims) && $user->customClaims["privilege_level"] == static::PRIVILEGE_LEVEL) {
                    $toReturn[] = $user;
                }
            }
            if (sizeof($toReturn) > 0) {
                return DBConf::instantiateAll(static::class, $toReturn);
            } else {
                return null;
            }
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
            return null;
        }
    }

    public static function instantiateFromJSON(string $jsonString): CityModerator|UniModerator|CountryModerator|null {
        $jsonObj = json_decode($jsonString, true);
        switch ($jsonObj["privilege_level"]){
            case 2:
                $toReturn = new CountryModerator();
                $toReturn->id = $jsonObj["id"];
                $toReturn->dbStored = $jsonObj["dbStored"];
                $toReturn->disabled = $jsonObj["disabled"];
                $toReturn->privilege_level = $jsonObj["privilege_level"];
                $toReturn->email = $jsonObj["email"];
                $toReturn->country_id = $jsonObj["country_id"];
                return $toReturn;
            case 3:
                $toReturn = new CityModerator();
                $toReturn->id = $jsonObj["id"];
                $toReturn->dbStored = $jsonObj["dbStored"];
                $toReturn->disabled = $jsonObj["disabled"];
                $toReturn->privilege_level = $jsonObj["privilege_level"];
                $toReturn->email = $jsonObj["email"];
                $toReturn->city_id = $jsonObj["city_id"];
                return $toReturn;
            case 4:
                $toReturn = new UniModerator();
                $toReturn->id = $jsonObj["id"];
                $toReturn->dbStored = $jsonObj["dbStored"];
                $toReturn->disabled = $jsonObj["disabled"];
                $toReturn->privilege_level = $jsonObj["privilege_level"];
                $toReturn->email = $jsonObj["email"];
                $toReturn->faculty_id = $jsonObj["faculty_id"];
                return $toReturn;
            default:
                return null;
        }
    }

    public static function getCount(): int {
        $tmp = static::getAll();
        if($tmp != null) {
            return sizeof($tmp);
        } else {
            return 0;
        }
    }
}