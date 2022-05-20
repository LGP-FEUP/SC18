<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\User;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class FacultyController extends UniModsBackOfficeController {

    /**
     * @throws DatabaseException
     */
    public function displayAll() {
        $faculty = App::getInstance()->auth->getFaculty();
        $city = App::getInstance()->auth->getCity();
        $country = App::getInstance()->auth->getCountry();
        if($faculty != null) {
            $this->render("faculties.list", ["faculty" => $faculty]);
        } elseif ($city != null) {
            $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
            $this->render("faculties.list", ["faculties" => Faculty::getAll(["city_id" => $city->id])]);
        } elseif ($country != null) {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $this->render("faculties.list", ["faculties" => Faculty::getAllByCountry($country)]);
        } else {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("faculties.list", ["faculties" => Faculty::getAll()]);
        }
    }

    /**
     * @throws DatabaseException
     */
    public function create() {
        $country = App::getInstance()->auth->getCountry();
        $city = App::getInstance()->auth->getCity();
        if($city != null) {
            $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
            $this->render("faculties.create", ["city" => $city]);
        } elseif ($country != null) {
            $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
            $this->render("faculties.create", ["cities" => City::getAll(["country_id" => $country->id])]);
        } else {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $this->render("faculties.create", ["cities" => City::getAll()]);
        }
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function createPost() {
        $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
        $faculty = new Faculty();
        if(Request::valuePost("name") && Request::valuePost("city_id")) {
            $faculty->id = App::UUIDGenerator();
            $faculty->name = Request::valuePost("name");
            $faculty->city_id = Request::valuePost("city_id");
            if($faculty->save()) {
                $this->redirect(Router::route("faculties"), ["success" => "Faculty added successfully."]);
            }
        }
        $this->redirect(Router::route("faculties"), ["error" => "Unable to add the faculty."]);
    }

    /**
     * @throws DatabaseException
     */
    public function edit($id) {
        $this->render("faculties.details", ["id" => $id, "cities" => City::getAll(), "students_incoming" => User::getAll(["faculty_arriving_id" => $id]), "students_outgoing" => User::getAll(["faculty_origin_id" => $id])]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function editPost($id) {
        $this->requirePrivileges(ADMIN_PRIVILEGES);
        $faculty = Faculty::select(["id" => $id]);
        if(Request::valuePost("name") && Request::valuePost("city_id") && $faculty && $faculty->exists()) {
            $faculty->name = Request::valuePost("name");
            $faculty->city_id = Request::valuePost("city_id");
            if($faculty->save()) {
                $this->redirect(Router::route("faculties"), ["success" => "Faculty edited."]);
            }
        }
        $this->redirect(Router::route("faculties"), ["error" => "Unable to edit the faculty."]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function delete($id) {
        $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
        $faculty = Faculty::select(["id" => $id]);
        if($faculty != null && $faculty->exists() && empty($faculty->getAssociatedStudents())) {
            if($faculty->delete()) {
                $this->redirect(Router::route("faculties"), ["success" => "Faculty deleted."]);
            }
        }
        $this->redirect(Router::route("faculties"), ["error" => "Failed to delete the faculty."]);
    }
}