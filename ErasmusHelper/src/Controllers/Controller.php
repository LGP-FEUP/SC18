<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Controllers\AbstractFrontController;
use ErasmusHelper\App;

abstract class Controller extends AbstractFrontController {

    protected bool $requireAuth = false;
    protected int $requirePrivilege = 0;

    public function __construct() {
        if($this->requireAuth) {
            if(!App::getInstance()->auth->isAuth()) {
                $this->redirect(Router::route("login"), ["error" => "You must be logged in to do this."]);
            }
        }
    }

}