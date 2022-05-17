<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Country;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class CountryController extends CountryModsBackOfficeController {

    /**
     * @throws DatabaseException
     */
    public function displayAll() {
        $this->render("countries.list", ["countries" => Country::getAll()]);
    }

    public function create() {
        $this->render("countries.create");
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function createPost() {
        $country = new Country();
        if(Request::valuePost("name")) {
            $country->id = App::UUIDGenerator();
            $country->name = Request::valuePost("name");
            if($country->save()) {
                $this->redirect(Router::route("countries"), ["success" => "Country added successfully."]);
            }
        }
        $this->redirect(Router::route("countries"), ["error" => "Unable to add the country."]);
    }

    /**
     * @throws DatabaseException
     */
    public function edit($id) {
        $this->render("countries.details", ["id" => $id, "cities" => City::getAll(["country_id" => $id])]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function editPost($id) {
        $country = Country::select(["id" => $id]);
        if(Request::valuePost("name") && $country && $country->exists()) {
            $country->name = Request::valuePost("name");
            if($country->save()) {
                $this->redirect(Router::route("countries"), ["success" => "Country edited."]);
            }
        }
        $this->redirect(Router::route("countries"), ["error" => "Unable to edit the country."]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function delete($id) {
        $country = Country::select(["id" => $id]);
        if($country != null && $country->exists() && empty($country->getAssociatedCities())) {
            if($country->delete()) {
                $this->redirect(Router::route("countries"), ["success" => "Country deleted."]);
            }
        }
        $this->redirect(Router::route("countries"), ["error" => "Failed to delete the country."]);
    }
}