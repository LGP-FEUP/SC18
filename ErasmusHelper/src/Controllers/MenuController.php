<?php

namespace ErasmusHelper\Controllers;

use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\CityModerator;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\CountryModerator;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\UniModerator;
use ErasmusHelper\Models\User;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class MenuController extends UniModsBackOfficeController {

    /**
     * @throws DatabaseException
     * @throws AuthException
     * @throws FirebaseException
     */
    public function displayAll() {
        $faculty = App::getInstance()->auth->getFaculty();
        $city = App::getInstance()->auth->getCity();
        $country = App::getInstance()->auth->getCountry();
        if($faculty != null) {
            $users_arriving = User::getCount(["faculty_arriving_id" => $faculty->id]);
            $users_origin = User::getCount(["faculty_origin_id" => $faculty->id]);
            $this->render("menu.list", [
                "usersCount" => User::getCount(),
                "usersIncoming" => $users_arriving,
                "usersOutgoing" => $users_origin,
                "type" => "faculty"
            ]);
        } elseif ($city != null) {
            $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
            $users_arriving = array();
            $users_origin = array();
            $users = User::getAll();
            foreach ($users as $user) {
                if(Faculty::select(["id" => $user->faculty_arriving_id])->city_id == $city->id) {
                    $users_arriving[] = $user;
                } elseif (Faculty::select(["id" => $user->faculty_origin_id])->city_id == $city->id) {
                    $users_origin[] = $user;
                }
            }
            $this->render("menu.list", [
                "usersCount" => sizeof($users),
                "usersIncoming" => sizeof($users_arriving),
                "usersOutgoing" => sizeof($users_origin),
                "type" => "city"
            ]);
        } elseif ($country != null) {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $users_arriving = array();
            $users_origin = array();
            $users = User::getAll();
            foreach ($users as $user) {
                if(Faculty::select(["id" => $user->faculty_arriving_id])->getCity()->country_id == $country->id) {
                    $users_arriving[] = $user;
                } elseif (Faculty::select(["id" => $user->faculty_origin_id])->getCity()->country_id == $country->id) {
                    $users_origin[] = $user;
                }
            }
            $this->render("menu.list", [
                "usersCount" => sizeof($users),
                "usersIncoming" => sizeof($users_arriving),
                "usersOutgoing" => sizeof($users_origin),
                "type" => "country"
            ]);
        } else {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("menu.list", [
                "usersCount" => User::getCount(),
                "uniModsCount" => UniModerator::getCount(),
                "cityModsCount" => CityModerator::getCount(),
                "countryModsCount" => CountryModerator::getCount()
            ]);
        }
    }

}