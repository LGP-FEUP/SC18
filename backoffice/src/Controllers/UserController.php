<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\User;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class UserController extends BackOfficeController {
    //TODO Searchbar in view and handle it here

    /**
     * @throws DatabaseException
     */
    public function displayAll() {
        $this->render("users.list", ["users" => User::getAll()]);
    }

    /**
     * @throws DatabaseException
     */
    public function create() {
        $this->render("users.create", ["countries" => Country::getAll(), "faculties" => Faculty::getAll()]);
    }

    /**
     * @throws Exception
     * @throws DatabaseException
     */
    #[NoReturn] public function createPost() {
        if(Request::valuePost("name")
            && Request::valuePost("firstname")
            && Request::valuePost("country_origin_id")
            && Request::valuePost("faculty_id")
            && Request::valuePost("validation_level")) {
            $user = new User();
            $user->id = App::UUIDGenerator();
            $user->name = Request::valuePost("name");
            $user->firstname = Request::valuePost("firstname");
            $faculty = Faculty::select(["id" => Request::valuePost("faculty_id")]);
            $user->country_origin_id = Request::valuePost("country_origin_id");
            $user->country_arriving_id = $faculty->getCity()->getCountry()->id;
            $user->faculty_id = $faculty->id;
            $user->validation_level = Request::valuePost("validation_level");

            $prop = array(
                "email" => Request::valuePost("email"),
                "password" => Request::valuePost("password"),
                "uid" => $user->id
            );
            try {
                App::getInstance()->firebase->auth->createUser($prop);
                if($user->save()) {
                    $this->redirect(Router::route("users"), ["success" => "User created successfully."]);
                }
            } catch (AuthException|FirebaseException $e) {
                Dbg::error($e->getMessage());
            }
        }
        $this->redirect(Router::route("users"), ["error" => "Unable to create the user."]);
    }

    /**
     * @throws DatabaseException
     */
    public function edit($id) {
        $this->render("users.details", ["id" => $id, "countries" => Country::getAll(), "faculties" => Faculty::getAll()]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function editPost($id) {
        $user = User::select(["id" => $id]);
        if(Request::valuePost("faculty_id")
            && Request::valuePost("validation_level")
            && $user && $user->exists() == 1) {
            $faculty = Faculty::select(["id" => Request::valuePost("faculty_id")]);
            $user->country_arriving_id = $faculty->getCity()->getCountry()->id;
            $user->faculty_id = $faculty->id;
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