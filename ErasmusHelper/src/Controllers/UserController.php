<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\User;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class UserController extends UniModsBackOfficeController {

    protected string $title = "Users";

    public function displayAll() {
        try {
            $faculty = App::getInstance()->auth->getFaculty();
            $city = App::getInstance()->auth->getCity();
            $country = App::getInstance()->auth->getCountry();

            if ($faculty != null) {
                $users = array();
                $users_arriving = User::getAll(["faculty_arriving_id" => $faculty->id]);
                $users_origin = User::getAll(["faculty_origin_id" => $faculty->id]);
                foreach ($users_arriving as $user) {
                    $users[] = $user;
                }
                foreach ($users_origin as $user) {
                    $users[] = $user;
                }
                $this->render("users.list", ["users" => $users]);
            } elseif ($city != null) {
                $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
                $users = array();
                $u = User::getAll();
                foreach ($u as $user) {
                    if (Faculty::select(["id" => $user->faculty_arriving_id])->city_id == $city->id || Faculty::select(["id" => $user->faculty_origin_id])->city_id == $city->id) {
                        $users[] = $user;
                    }
                }
                $this->render("users.list", ["users" => $users]);
            } elseif ($country != null) {
                $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
                $users = array();
                $u = User::getAll();
                foreach ($u as $user) {
                    if (Faculty::select(["id" => $user->faculty_arriving_id])->getCity()->country_id == $country->id || Faculty::select(["id" => $user->faculty_origin_id])->getCity()->country_id == $country->id) {
                        $users[] = $user;
                    }
                }
                $this->render("users.list", ["users" => $users]);
            } else {
                $this->requirePrivileges(ADMIN_PRIVILEGES);
                $this->render("users.list", ["users" => User::getAll()]);
            }
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    public function edit($id) {
        $this->render("users.details", ["id" => $id, "faculties" => Faculty::getAll()]);
    }

    #[NoReturn] public function editPost($id) {
        try {
            $user = User::select(["id" => $id]);
            if (Request::valuePost("faculty_id")
                && Request::valuePost("validation_level")
                && $user && $user->exists() == 1) {
                $user->faculty_arriving_id = Request::valuePost("faculty_id");
                $user->validation_level = Request::valuePost("validation_level");
                if ($user->save()) {
                    $this->redirect(Router::route("users"), ["success" => "User edited."]);
                }
            }
            $this->redirect(Router::route("users"), ["error" => "Unable to edit the user."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function changeAbility($id) {
        try {
            $user = User::select(["id" => $id]);
            if ($user != null && $user->exists()) {
                if ($user->changeAbility()) {
                    $this->redirect(Router::route("users"), ["success" => "User ability updated."]);
                }
            }
            $this->redirect(Router::route("users"), ["error" => "Failed to update the user ability."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

}