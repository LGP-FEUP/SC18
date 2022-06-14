<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Country;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class CountryController extends CountryModsBackOfficeController {

    protected string $title = "Countries";

    public function displayAll() {
        $country = App::getInstance()->auth->getCountry();
        if ($country == null) {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("countries.list", ["countries" => Country::getAll()]);
        } else {
            $this->render("countries.list", ["country" => $country]);
        }
    }

    public function create() {
        $this->requirePrivileges(ADMIN_PRIVILEGES);
        $this->render("countries.create");
    }

    #[NoReturn] public function createPost() {
        $this->requirePrivileges(ADMIN_PRIVILEGES);
        $country = new Country();
        if (Request::valuePost("name")) {
            $country->id = App::UUIDGenerator();
            $country->name = Request::valuePost("name");
            if ($country->save()) {
                $this->redirect(Router::route("countries"), ["success" => "Country added successfully."]);
            }
        }
        $this->redirect(Router::route("countries"), ["error" => "Unable to add the country."]);
    }

    public function edit($id) {
        $this->render("countries.details", ["id" => $id, "cities" => City::getAll(["country_id" => $id])]);
    }

    #[NoReturn] public function editPost($id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $country = Country::select(["id" => $id]);
            if (Request::valuePost("name") && $country && $country->exists()) {
                $country->name = Request::valuePost("name");
                if ($country->save()) {
                    $this->redirect(Router::route("countries"), ["success" => "Country edited."]);
                }
            }
            $this->redirect(Router::route("countries"), ["error" => "Unable to edit the country."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function delete($id) {
        try {
            $country = Country::select(["id" => $id]);
            if ($country != null && $country->exists() && empty($country->getAssociatedCities())) {
                if ($country->delete()) {
                    $this->redirect(Router::route("countries"), ["success" => "Country deleted."]);
                }
            }
            $this->redirect(Router::route("countries"), ["error" => "Failed to delete the country."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }
}