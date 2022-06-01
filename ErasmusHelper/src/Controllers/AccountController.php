<?php

namespace ErasmusHelper\Controllers;


use AgileBundle\Utils\Dbg;
use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class AccountController extends UniModsBackOfficeController {

    public function edit() {
        $this->render("account.details");
    }

    public function editPost() {
        try {
            if (Request::valuePost("email") && Request::valuePost("password")) {
                Dbg::error(Request::valuePost("email"));
                Dbg::error(Request::valuePost("password"));
                App::getInstance()->firebase->auth->changeUserEmail(App::getInstance()->auth->getAdminUID(), Request::valuePost("email"));
                App::getInstance()->firebase->auth->changeUserPassword(App::getInstance()->auth->getAdminUID(), Request::valuePost("password"));
                $this->redirect(Router::route("menu"), ["success", "User modified successfully."]);
            }
        } catch (AuthException|FirebaseException $e) {
            Dbg::error($e->getMessage());
        }
        $this->redirect(Router::route("menu"), ["error", "Error while modifying the user, please try again later."]);
    }
}