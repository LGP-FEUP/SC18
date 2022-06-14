<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use AgileBundle\Utils\Request;
use ErasmusHelper\Models\BackOfficeRequest;
use ErasmusHelper\Models\StaffModel;
use ErasmusHelper\Models\User;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class ModalController extends UniModsBackOfficeController {

    protected bool $async = true;

    public function searchUsers() {
        try {
            $users = array();
            foreach ($_POST as $user) {
                $users[] = new User(json_decode($user, true));
            }
            $this->render("users.search", ["users" => $users]);
        } catch (Exception $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    public function importExcel() {
        $this->render("users.excel");
    }

    #[NoReturn] public function importExcelPost() {
        $specificExcel = null;
        if(Request::valuePost("email")
            && Request::valuePost("firstname")
            && Request::valuePost("lastname")
            && Request::valuePost("origin_university")
            && Request::valuePost("origin_university_code")
            && Request::valuePost("date_of_birth")
            && Request::valuePost("city_of_origin_university")
            && Request::valuePost("country_of_origin_university")) {
            $specificExcel["email"] = strtolower(Request::valuePost("email"));
            $specificExcel["firstname"] = strtolower(Request::valuePost("firstname"));
            $specificExcel["lastname"] = strtolower(Request::valuePost("lastname"));
            $specificExcel["origin_university"] = strtolower(Request::valuePost("origin_university"));
            $specificExcel["origin_university_code"] = strtolower(Request::valuePost("origin_university_code"));
            $specificExcel["date_of_birth"] = strtolower(Request::valuePost("date_of_birth"));
            $specificExcel["city_of_origin_university"] = strtolower(Request::valuePost("city_of_origin_university"));
            $specificExcel["country_of_origin_university"] = strtolower(Request::valuePost("country_of_origin_university"));
        }
        if(ExcelController::sendEmails($_FILES['excel']['tmp_name'], $specificExcel)) {
            $this->redirect(Router::route("users"), ["success" => "Excel uploaded, sent emails to corresponding addresses and updated data."]);
        } else {
            $this->redirect(Router::route("users"), ["error" => "Invalid file or unable to send mails."]);
        }
    }

    public function searchStaffs() {
        $staffs = array();
        foreach ($_POST as $staff) {
            $staffs[] = StaffModel::instantiateFromJSON($staff);
        }
        $this->render("staffs.search", ["staffs" => $staffs]);
    }

    public function requestDetails() {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $request = BackOfficeRequest::select(["id" => array_key_first($_POST)]);
            if ($request != null && $request->exists()) {
                $this->render("menu.requests.details", ["request" => $request]);
            }
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    public function requestsHistory() {
        $this->requirePrivileges(ADMIN_PRIVILEGES);
        $this->render("menu.requests.history", ["requests" => BackOfficeRequest::getAll()]);
    }

}