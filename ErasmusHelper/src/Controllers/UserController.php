<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\User;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class UserController extends UniModsBackOfficeController {
    //TODO Searchbar in view and handle it here

    /**
     * @throws DatabaseException
     */
    public function displayAll() {
        $faculty = App::getInstance()->auth->getFaculty();
        if($faculty == null) {
            $this->render("users.list", ["users" => User::getAll()]);
        } else {
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
        }
    }

    /**
     * @throws DatabaseException
     */
    public function edit($id) {
        $this->render("users.details", ["id" => $id, "faculties" => Faculty::getAll()]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function editPost($id) {
        $user = User::select(["id" => $id]);
        if(Request::valuePost("faculty_id")
            && Request::valuePost("validation_level")
            && $user && $user->exists() == 1) {
            $user->faculty_arriving_id = Request::valuePost("faculty_id");
            $user->validation_level = Request::valuePost("validation_level");
            if($user->save()) {
                $this->redirect(Router::route("users"), ["success" => "User edited."]);
            }
        }
        $this->redirect(Router::route("users"), ["error" => "Unable to edit the user."]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function changeAbility($id) {
        $user = User::select(["id" => $id]);
        if($user != null && $user->exists()) {
            if($user->changeAbility()) {
                $this->redirect(Router::route("users"), ["success" => "User ability updated."]);
            }
        }
        $this->redirect(Router::route("users"), ["error" => "Failed to update the user ability."]);
    }

}