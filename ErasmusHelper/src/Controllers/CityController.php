<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\Faculty;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class CityController extends CityModsBackOfficeController {

    /**
     * @throws DatabaseException
     */
    public function displayAll() {
        $city = App::getInstance()->auth->getCity();
        $country = App::getInstance()->auth->getCountry();
        if($city != null) {
            $this->render("cities.list", ["city" => $city]);
        } elseif($country != null) {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $this->render("cities.list", ["cities" => City::getAll(["country_id" => $country->id])]);
        } else {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("cities.list", ["cities" => City::getAll()]);
        }
    }

    /**
     * @throws DatabaseException
     */
    public function create() {
        $country = App::getInstance()->auth->getCountry();
        if($country == null) {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("cities.create", ["countries" => Country::getAll()]);
        } else {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $this->render("cities.create", ["country" => $country]);
        }
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function createPost() {
        $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
        $city = new City();
        if(Request::valuePost("name") && Request::valuePost("country_id")) {
            $city->id = App::UUIDGenerator();
            $city->name = Request::valuePost("name");
            $city->country_id = Request::valuePost("country_id");
            if($city->save()) {
                $this->redirect(Router::route("cities"), ["success" => "City added successfully."]);
            }
        }
        $this->redirect(Router::route("cities"), ["error" => "Unable to add the city."]);
    }

    /**
     * @throws DatabaseException
     */
    public function edit($id) {
        $this->render("cities.details", ["id" => $id, "countries" => Country::getAll(), "faculties" => Faculty::getAll(["city_id" => $id])]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function editPost($id) {
        $this->requirePrivileges(ADMIN_PRIVILEGES);
        $city = City::select(["id" => $id]);
        if(Request::valuePost("name") && Request::valuePost("country_id") && $city && $city->exists()) {
            $city->name = Request::valuePost("name");
            $city->country_id = Request::valuePost("country_id");
            if($city->save()) {
                $this->redirect(Router::route("cities"), ["success" => "City edited."]);
            }
        }
        $this->redirect(Router::route("cities"), ["error" => "Unable to edit the city."]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function delete($id) {
        $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
        $city = City::select(["id" => $id]);
        if($city != null && $city->exists() && empty($city->getAssociatedFaculties())) {
            if($city->delete()) {
                $this->redirect(Router::route("cities"), ["success" => "City deleted."]);
            }
        }
        $this->redirect(Router::route("cities"), ["error" => "Failed to delete the city."]);
    }

}