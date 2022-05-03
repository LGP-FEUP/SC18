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

    const COLUMNS = ["id", "name", "firstname", "validation_level", "country_origin_id", "country_arriving_id", "faculty_id", "date_of_birth"];

    public $name;
    public $firstname;
    public $validation_level;
    public $country_origin_id;
    public $country_arriving_id;
    public $faculty_id;
    public $date_of_birth;
    private $authUser = null;

    /**
     * @throws FirebaseException
     * @throws AuthException
     * @throws Exception
     */
    public function __construct(array $data = null) {
        parent::__construct($data);
        if($this->exists()) {
            $this->authUser = App::getInstance()->firebase->auth->getUser($this->id);
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
     * @return Faculty|null
     * @throws DatabaseException
     */
    public function getFaculty(): ?Faculty {
        if($this->faculty_id) {
            return Faculty::select(["id" => $this->faculty_id]);
        } else {
            Dbg::error("Unable to find faculty for such user.");
            return null;
        }
    }

    /**
     * Returns the Country object for arriving or origin country of the user.
     *
     * @param bool $origin true if origin, false if arriving.
     * @return Country
     * @throws DatabaseException
     */
    public function getCountry(bool $origin = true): Country {
        if($origin) {
            return Country::select(["id" => $this->country_origin_id]);
        } else {
            return Country::select(["id" => $this->country_arriving_id]);
        }
    }

    /**
     * Disable the current user if it was enabled / Enable the current user if it was disabled.
     *
     * @return bool
     * @throws AuthException
     * @throws FirebaseException
     */
    public function changeAbility(): bool {
        if($this->authUser) {
            if($this->isDisabled()) {
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
            Dbg::error("Unable to find email for such user.");
            return null;
        }
    }

}