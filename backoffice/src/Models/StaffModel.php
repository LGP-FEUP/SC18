<?php

namespace ErasmusHelper\Models;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\App;
use ErasmusHelper\Core\DBConf;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

abstract class StaffModel {

    public const PRIVILEGE_LEVEL = 0;

    const CLAIMS = [];

    public string $id = "";
    public string $email = "";
    public bool $disabled = false;
    public bool $dbStored = false;

    /**
     * Constructs an object. If it comes from database (= $date is nul null), hydrates it.
     * Otherwise, generates a new UUID for this object.
     *
     * @throws Exception
     */
    public function __construct(UserRecord $user = null) {
        if($user != null) {
            $this->hydrate($user);
        } else {
            $this->id = App::UUIDGenerator();
        }
    }

    /**
     * Hydrates a staff member with corresponding claims.
     *
     * @param UserRecord $user
     * @return void
     */
    protected function hydrate(UserRecord $user) {
        $this->dbStored = true;
        $this->id = $user->uid;
        $this->disabled = $user->disabled;
        $this->email = $user->email;
        foreach (static::CLAIMS as $claim) {
            $this->$claim = $user->customClaims[$claim];
        }
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
     * @throws AuthException
     * @throws FirebaseException
     */
    public static function getById(string $id): mixed {
        $userRecord = App::getInstance()->firebase->auth->getUser($id);
        if($userRecord->customClaims["privilege_level"] == static::PRIVILEGE_LEVEL) {
            return DBConf::instantiateAuth(static::class, $userRecord);
        }
        return null;
    }

    /**
     *
     *
     * @throws FirebaseException
     * @throws AuthException
     */
    public static function getAll(): ?array {
        $all = App::getInstance()->firebase->auth->listUsers();
        $toReturn = array();
        foreach ($all as $user) {
            if(!empty($user->customClaims) && $user->customClaims["privilege_level"] == static::PRIVILEGE_LEVEL) {
                $toReturn[] = $user;
            }
        }
        if(sizeof($toReturn) > 0) {
            return DBConf::instantiateAll(static::class, $toReturn);
        } else {
            return null;
        }
    }

}