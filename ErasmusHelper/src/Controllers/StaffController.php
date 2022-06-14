<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\CityModerator;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\CountryModerator;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\UniModerator;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class StaffController extends CityModsBackOfficeController {

    protected string $title = "Staffs";

    public function displayAll() {
        try {
            $city = App::getInstance()->auth->getCity();
            $country = App::getInstance()->auth->getCountry();
            $cityMods = CityModerator::getAll();
            $staffs = array();
            $uniMods = UniModerator::getAll();
            if ($city != null) {
                foreach ($uniMods as $mod) {
                    if (Faculty::select(["id" => $mod->faculty_id])->getCity() == $city) {
                        $staffs[] = $mod;
                    }
                }
            } elseif ($country != null) {
                $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
                foreach ($uniMods as $fmod) {
                    if (Faculty::select(["id" => $fmod->faculty_id])->getCity()->getCountry() == $country) {
                        $staffs[] = $fmod;
                    }
                }
                foreach ($cityMods as $cmod) {
                    if (City::select(["id" => $cmod->city_id])->getCountry() == $country) {
                        $staffs[] = $cmod;
                    }
                }
            } else {
                $this->requirePrivileges(ADMIN_PRIVILEGES);
                $countryMods = CountryModerator::getAll();
                foreach ($countryMods as $comod) {
                    $staffs[] = $comod;
                }
                foreach ($cityMods as $cmod) {
                    $staffs[] = $cmod;
                }
                foreach ($uniMods as $umod) {
                    $staffs[] = $umod;
                }
            }
            $this->render("staffs.list", ["staffs" => $staffs]);
        } catch (DatabaseException|AuthException|FirebaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    public function create() {
        $city = App::getInstance()->auth->getCity();
        $country = App::getInstance()->auth->getCountry();
        if ($city != null) {
            $this->render("staffs.create", ["faculties" => Faculty::getAll(["city_id" => $city->id])]);
        } elseif ($country != null) {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $this->render("staffs.create", ["faculties" => Faculty::getAllByCountry($country), "cities" => City::getAll(["country_id" => $country->id])]);
        } else {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("staffs.create", ["faculties" => Faculty::getAll(), "cities" => City::getAll(), "countries" => Country::getAll()]);
        }
    }

    #[NoReturn]
    public function createUniPost() {
        if(Request::valuePost("email")
            && Request::valuePost("password")
            && Request::valuePost("faculty_id")) {
            $prop = array(
                "email" => Request::valuePost("email"),
                "password" => Request::valuePost("password")
            );
            try {
                $user = App::getInstance()->firebase->auth->createUser($prop);
                App::getInstance()->firebase->auth->setCustomUserClaims($user->uid, [
                    "faculty_id" => Request::valuePost("faculty_id"),
                    "privilege_level" => UniModerator::PRIVILEGE_LEVEL
                ]);
                $this->redirect(Router::route("staffs"), ["success" => "Uni Moderator created successfully."]);
            } catch (AuthException|FirebaseException $e) {
                Dbg::error($e->getMessage());
            }
        }
        $this->redirect(Router::route("staffs"), ["error" => "Unable to create the Uni Moderator."]);
    }

    #[NoReturn]
    public function createCityPost() {
        $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
        if(Request::valuePost("email")
            && Request::valuePost("password")
            && Request::valuePost("city_id")) {
            $prop = array(
                "email" => Request::valuePost("email"),
                "password" => Request::valuePost("password")
            );
            try {
                $user = App::getInstance()->firebase->auth->createUser($prop);
                App::getInstance()->firebase->auth->setCustomUserClaims($user->uid, [
                    "city_id" => Request::valuePost("city_id"),
                    "privilege_level" => CityModerator::PRIVILEGE_LEVEL
                ]);
                $this->redirect(Router::route("staffs"), ["success" => "City Moderator created successfully."]);
            } catch (AuthException|FirebaseException $e) {
                Dbg::error($e->getMessage());
            }
        }
        $this->redirect(Router::route("staffs"), ["error" => "Unable to create the City Moderator."]);
    }

    #[NoReturn]
    public function createCountryPost() {
        $this->requirePrivileges(ADMIN_PRIVILEGES);
        if(Request::valuePost("email")
            && Request::valuePost("password")
            && Request::valuePost("country_id")) {
            $prop = array(
                "email" => Request::valuePost("email"),
                "password" => Request::valuePost("password")
            );
            try {
                $user = App::getInstance()->firebase->auth->createUser($prop);
                App::getInstance()->firebase->auth->setCustomUserClaims($user->uid, [
                    "country_id" => Request::valuePost("country_id"),
                    "privilege_level" => CountryModerator::PRIVILEGE_LEVEL
                ]);
                $this->redirect(Router::route("staffs"), ["success" => "Country Moderator created successfully."]);
            } catch (AuthException|FirebaseException $e) {
                Dbg::error($e->getMessage());
            }
        }
        $this->redirect(Router::route("staffs"), ["error" => "Unable to create the Country Moderator."]);
    }

    public function edit($id) {
        $city = App::getInstance()->auth->getCity();
        $country = App::getInstance()->auth->getCountry();
        if ($city != null) {
            $this->render("staffs.details", ["id" => $id, "faculties" => Faculty::getAll(["city_id" => $city->id])]);
        } elseif ($country != null) {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $this->render("staffs.details", ["id" => $id, "faculties" => Faculty::getAllByCountry($country), "cities" => City::getAll(["country_id" => $country->id])]);
        } else {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("staffs.details", ["id" => $id, "faculties" => Faculty::getAll(), "cities" => City::getAll(), "countries" => Country::getAll()]);
        }
    }

    #[NoReturn] public function editUniPost($id) {
        try {
            $this->requirePrivileges();
            $staff = UniModerator::getById($id);
            if (Request::valuePost("faculty_id")
                && Request::valuePost("email")
                && $staff && $staff->exists() == 1) {
                $staff->faculty_id = Request::valuePost("faculty_id");
                $staff->email = Request::valuePost("email");
                App::getInstance()->firebase->auth->setCustomUserClaims($staff->id, [
                    "faculty_id" => Request::valuePost("faculty_id"),
                    "privilege_level" => UniModerator::PRIVILEGE_LEVEL
                ]);
                if ($staff->save()) {
                    $this->redirect(Router::route("staffs"), ["success" => "Uni Moderator edited."]);
                }
            }
            $this->redirect(Router::route("staffs"), ["error" => "Unable to edit the Uni Moderator."]);
        } catch (AuthException|FirebaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function editCityPost($id) {
        try {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $staff = CityModerator::getById($id);
            if (Request::valuePost("city_id")
                && Request::valuePost("email")
                && $staff && $staff->exists() == 1) {
                $staff->city_id = Request::valuePost("city_id");
                $staff->email = Request::valuePost("email");
                App::getInstance()->firebase->auth->setCustomUserClaims($staff->id, [
                    "city_id" => Request::valuePost("city_id"),
                    "privilege_level" => CityModerator::PRIVILEGE_LEVEL
                ]);
                if ($staff->save()) {
                    $this->redirect(Router::route("staffs"), ["success" => "City Moderator edited."]);
                }
            }
            $this->redirect(Router::route("staffs"), ["error" => "Unable to edit the City Moderator."]);
        } catch (AuthException|FirebaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function editCountryPost($id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $staff = CountryModerator::getById($id);
            if (Request::valuePost("country_id")
                && Request::valuePost("email")
                && $staff && $staff->exists() == 1) {
                $staff->country_id = Request::valuePost("country_id");
                $staff->email = Request::valuePost("email");
                App::getInstance()->firebase->auth->setCustomUserClaims($staff->id, [
                    "country_id" => Request::valuePost("country_id"),
                    "privilege_level" => CountryModerator::PRIVILEGE_LEVEL
                ]);
                if ($staff->save()) {
                    $this->redirect(Router::route("staffs"), ["success" => "Country Moderator edited."]);
                }
            }
            $this->redirect(Router::route("staffs"), ["error" => "Unable to edit the Country Moderator."]);
        } catch (AuthException|FirebaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function changeAbility($id) {
        try {
            $uniMod = UniModerator::getById($id);
            $cityMod = CityModerator::getById($id);
            $countryMod = CountryModerator::getById($id);

            if ($uniMod != null) {
                $staff = $uniMod;
            } elseif ($cityMod != null) {
                $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
                $staff = $cityMod;
            } else {
                $this->requirePrivileges(ADMIN_PRIVILEGES);
                $staff = $countryMod;
            }
            if ($staff != null && $staff->exists()) {
                if ($staff->changeAbility()) {
                    $this->redirect(Router::route("staffs"), ["success" => "Staff member ability updated."]);
                }
            }
            $this->redirect(Router::route("staffs"), ["error" => "Failed to update the staff member ability."]);
        } catch (AuthException|FirebaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

}