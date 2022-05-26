<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\Models\BackOfficeRequest;
use ErasmusHelper\Models\StaffModel;
use ErasmusHelper\Models\User;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class ModalController extends UniModsBackOfficeController {

    protected bool $async = true;

    /**
     * @throws FirebaseException
     * @throws AuthException
     */
    public function searchUsers() {
        $users = array();
        foreach ($_POST as $user) {
            $users[] = new User(json_decode($user, true));
        }
        $this->render("users.search", ["users" => $users]);
    }

    public function searchStaffs() {
        $staffs = array();
        foreach ($_POST as $staff) {
            $staffs[] = StaffModel::instantiateFromJSON($staff);
        }
        $this->render("staffs.search", ["staffs" => $staffs]);
    }

    /**
     * @throws DatabaseException
     */
    public function requestDetails() {
        $this->requirePrivileges(ADMIN_PRIVILEGES);
        $request = BackOfficeRequest::select(["id" => array_key_first($_POST)]);
        if($request != null && $request->exists()) {
            $this->render("menu.requests.details", ["request" => $request]);
        }
    }

    /**
     * @throws DatabaseException
     */
    public function requestsHistory() {
        $this->requirePrivileges(ADMIN_PRIVILEGES);
        $this->render("menu.requests.history", ["requests" => BackOfficeRequest::getAll()]);
    }
}