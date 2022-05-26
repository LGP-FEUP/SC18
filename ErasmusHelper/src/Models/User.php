<?php

namespace ErasmusHelper\Models;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\App;
use Exception;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class User extends Model {

    const STORAGE = 'users';

    const COLUMNS = ["id", "lastname", "firstname", "validation_level", "faculty_origin_id", "faculty_arriving_id", "date_of_birth"];

    public $lastname;
    public $firstname;
    public $validation_level;
    public $faculty_origin_id;
    public $faculty_arriving_id;
    public $date_of_birth;
    private $authUser = null;

    public function __construct(array $data = null) {
        parent::__construct($data);
        try {
            if ($this->exists()) {
                $this->authUser = App::getInstance()->firebase->auth->getUser($this->id);
            }
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
        }
    }

    /**
     * Computes the user's birthdate to a dd/mm/yyyy format.
     *
     * @return string
     */
    public function computeBirthDate(): string {
        $toReturn = "";
        foreach($this->date_of_birth as $key => $value) {
            if($key != "year") {
                if($value < 10) {
                    $toReturn = $toReturn . "0".$value . "/";
                } else {
                    $toReturn = $toReturn . $value . "/";
                }
            } else {
                $toReturn = $toReturn . $value;
            }
        }
        return $toReturn;
    }

    /**
     * Returns the email for the user.
     *
     * @return string|null
     */
    public function getEmail(): ?string {
        if($this->authUser) {
            return $this->authUser->email;
        } else {
            Dbg::error("Unable to find email for such user.");
            return null;
        }
    }

    /**
     * Returns the faculty for the user.
     *
     * @param bool $arriving true for faculty of arriving, false for faculty of origin
     * @return Faculty|null
     */
    public function getFaculty(bool $arriving = true): ?Faculty {
        if ($arriving) {
            if ($this->faculty_arriving_id) {
                return Faculty::select(["id" => $this->faculty_arriving_id]);
            } else {
                Dbg::error("Unable to find faculty arriving for such user.");
                return null;
            }
        } else {
            if ($this->faculty_origin_id) {
                return Faculty::select(["id" => $this->faculty_origin_id]);
            } else {
                Dbg::error("Unable to find faculty of origin for such user.");
                return null;
            }
        }
    }

    /**
     * Disable the current user if it was enabled / Enable the current user if it was disabled.
     *
     * @return bool
     */
    public function changeAbility(): bool {
        try {
            if ($this->authUser) {
                if ($this->isDisabled()) {
                    $properties = array(
                        "disabled" => false
                    );
                } else {
                    $properties = array(
                        "disabled" => true
                    );
                }
                App::getInstance()->firebase->auth->updateUser($this->id, $properties);
                $this->authUser = App::getInstance()->firebase->auth->getUser($this->id);
                return true;
            } else {
                Dbg::error("Unable to update the user ability.");
                return false;
            }
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
            return false;
        }
    }

    /**
     * Return is the user is disabled or not.
     *
     * @return bool|null
     */
    public function isDisabled(): ?bool {
        if($this->authUser) {
            return $this->authUser->disabled;
        } else {
            Dbg::error("Unable to find auth entity for such user.");
            return null;
        }
    }

}