<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Lcobucci\JWT\Exception;

class AuthController extends Controller {

    protected string $layout = "login";

    /**
     * Login page
     */
    public function login() {
        if (App::getInstance()->auth->isAuth()){
            $this->redirect(Router::route("/"), ["success" => "Connection successful"]);
        } else {
            $this->render("auth.login", [
                "loginError" => Request::valueRequest("loginError")
            ]);
        }
    }

    /**
     * Form to try to connect an admin
     */
    #[NoReturn] public function auth() {
        $email = Request::valuePost("mail");
        $password = Request::valuePost("password");
        $error = "Error, please fill in password and email.";
        if ($password != null && $email != null) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (App::getInstance()->auth->login($email, $password)) {
                    $this->redirect(Router::route("menu"), ["success" => "Connection successful"]);
                } else $error = "Unknown user or invalid password";
            } else $error = "Invalid email";
        }
        $this->redirect(Router::route("login"), ["error" => $error]);
    }

    #[NoReturn] public function logout() {
        App::getInstance()->auth->logout();
        $this->redirect(Router::route("/"), ["success" => "Logged Out successfully"]);
    }
}