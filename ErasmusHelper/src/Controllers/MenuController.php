<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use DateTime;
use ErasmusHelper\App;
use ErasmusHelper\Models\BackOfficeRequest;
use ErasmusHelper\Models\CityModerator;
use ErasmusHelper\Models\CountryModerator;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\UniModerator;
use ErasmusHelper\Models\User;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;

class MenuController extends UniModsBackOfficeController {

    protected string $title = "Menu";

    public function displayAll() {
        try {
            $faculty = App::getInstance()->auth->getFaculty();
            $city = App::getInstance()->auth->getCity();
            $country = App::getInstance()->auth->getCountry();
            if ($faculty != null) {
                $users_arriving = User::getCount(["faculty_arriving_id" => $faculty->id]);
                $users_origin = User::getCount(["faculty_origin_id" => $faculty->id]);
                $this->render("menu.list", [
                    "usersCount" => User::getCount(),
                    "usersIncoming" => $users_arriving,
                    "usersOutgoing" => $users_origin,
                    "type" => "faculty"
                ]);
            } elseif ($city != null) {
                $this->requirePrivileges(CITYMODERATORS_PRIVILEGES);
                $users_arriving = array();
                $users_origin = array();
                $users = User::getAll();
                foreach ($users as $user) {
                    if (Faculty::select(["id" => $user->faculty_arriving_id])->city_id == $city->id) {
                        $users_arriving[] = $user;
                    } elseif (Faculty::select(["id" => $user->faculty_origin_id])->city_id == $city->id) {
                        $users_origin[] = $user;
                    }
                }
                $this->render("menu.list", [
                    "usersCount" => sizeof($users),
                    "usersIncoming" => sizeof($users_arriving),
                    "usersOutgoing" => sizeof($users_origin),
                    "type" => "city"
                ]);
            } elseif ($country != null) {
                $this->requirePrivileges(COUNTRYMODERATORS_PRIVILEGES);
                $users_arriving = array();
                $users_origin = array();
                $users = User::getAll();
                foreach ($users as $user) {
                    if (Faculty::select(["id" => $user->faculty_arriving_id])->getCity()->country_id == $country->id) {
                        $users_arriving[] = $user;
                    } elseif (Faculty::select(["id" => $user->faculty_origin_id])->getCity()->country_id == $country->id) {
                        $users_origin[] = $user;
                    }
                }
                $this->render("menu.list", [
                    "usersCount" => sizeof($users),
                    "usersIncoming" => sizeof($users_arriving),
                    "usersOutgoing" => sizeof($users_origin),
                    "type" => "country"
                ]);
            } else {
                $this->requirePrivileges(ADMIN_PRIVILEGES);
                $this->render("menu.list", [
                    "usersCount" => User::getCount(),
                    "uniModsCount" => UniModerator::getCount(),
                    "cityModsCount" => CityModerator::getCount(),
                    "countryModsCount" => CountryModerator::getCount(),
                    "requests" => BackOfficeRequest::getAll(["status" => 0])
                ]);
            }
        } catch (DatabaseException|AuthException|FirebaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function requestCreate() {
        try {
            if (Request::valuePost("title") && Request::valuePost("content")) {
                $request = new BackOfficeRequest();
                $request->id = App::UUIDGenerator();
                $request->date = new DateTime();
                $request->content = Request::valuePost("content");
                $request->title = Request::valuePost("title");
                $request->status = 0;
                $request->author = App::getInstance()->firebase->auth->getUser(App::getInstance()->auth->getAdminUID())->email;
                $request->save();
                $this->redirect(Router::route("menu"), ["success", "Request sent successfully."]);
            }
            $this->redirect(Router::route("menu"), ["error", "Unable to create a new request."]);
        } catch (AuthException|FirebaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function requestReject(string $id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $request = BackOfficeRequest::select(["id" => $id]);
            if ($request != null && $request->exists()) {
                $request->status = 2;
                $request->save();
                $this->redirect(Router::route("menu"), ["success", "Request rejected."]);
            }
            $this->redirect(Router::route("menu"), ["error", "Unable to change the request status."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function requestValidate(string $id) {
        try {
            $this->requirePrivileges(ADMIN_PRIVILEGES);
            $request = BackOfficeRequest::select(["id" => $id]);
            if ($request != null && $request->exists()) {
                $request->status = 1;
                $request->save();
                $this->redirect(Router::route("menu"), ["success", "Request validated."]);
            }
            $this->redirect(Router::route("menu"), ["error", "Unable to change the request status."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }
}