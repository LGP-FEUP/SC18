<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\UniModerator;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class StaffController extends BackOfficeController {

    /**
     * @throws AuthException
     * @throws FirebaseException
     */
    public function displayAll() {
        $this->render("staffs.list", ["staffs" => UniModerator::getAll()]);
    }

    /**
     * @throws DatabaseException
     */
    public function create() {
        $this->render("staffs.create", ["faculties" => Faculty::getAll()]);
    }

    #[NoReturn]
    public function createPost() {
        if(Request::valuePost("email")
            && Request::valuePost("password")
            && Request::valuePost("faculty_id")
            && Request::valuePost("privilege_level")) {
            $staff = new UniModerator();

            $prop = array(
                "email" => Request::valuePost("email"),
                "password" => Request::valuePost("password"),
                "uid" => $staff->id
            );
            try {
                App::getInstance()->firebase->auth->createUser($prop);
                App::getInstance()->firebase->auth->setCustomUserClaims($staff->id, [
                    "faculty_id" => Request::valuePost("faculty_id"),
                    "privilege_level" => Request::valuePost("privilege_level")
                ]);
                $this->redirect(Router::route("staffs"), ["success" => "Staff member created successfully."]);
            } catch (AuthException|FirebaseException $e) {
                Dbg::error($e->getMessage());
            }
        }
        $this->redirect(Router::route("staffs"), ["error" => "Unable to create the staff member."]);
    }

    /**
     * @throws DatabaseException
     */
    public function edit($id) {
        $this->render("staffs.details", ["id" => $id, "faculties" => Faculty::getAll()]);
    }

    /**
     * @todo Support more than just uni-moderators.
     *
     * @param $id
     * @throws AuthException
     * @throws FirebaseException
     */
    #[NoReturn] public function editPost($id) {
        $staff = UniModerator::getById($id);
        if(Request::valuePost("faculty_id")
            && Request::valuePost("email")
            && $staff && $staff->exists() == 1) {
            $staff->faculty_id = Request::valuePost("faculty_id");
            $staff->email = Request::valuePost("email");
            App::getInstance()->firebase->auth->setCustomUserClaims($staff->id, [
                "faculty_id" => Request::valuePost("faculty_id"),
                "privilege_level" => UniModerator::PRIVILEGE_LEVEL
            ]);
            if($staff->save()) {
                $this->redirect(Router::route("staffs"), ["success" => "Staff member edited."]);
            }
        }
        $this->redirect(Router::route("staffs"), ["error" => "Unable to edit the staff member."]);
    }

    /**
     * @param $id
     * @throws AuthException
     * @throws FirebaseException
     */
    #[NoReturn] public function changeAbility($id) {
        $staff = UniModerator::getById($id);
        if($staff != null && $staff->exists()) {
            if($staff->changeAbility()) {
                $this->redirect(Router::route("staffs"), ["success" => "Staff member ability updated."]);
            }
        }
        $this->redirect(Router::route("staffs"), ["error" => "Failed to update the staff member ability."]);
    }

}