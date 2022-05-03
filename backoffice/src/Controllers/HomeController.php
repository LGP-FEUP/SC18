<?php

namespace ErasmusHelper\Controllers;

class HomeController extends Controller {


    public function home(): void {
        //$this->render("generic.404", ["UID" => "2"]);
        //$this->redirect(Router::route("countries", ["id" => 1]), ["error" => "Unallowed."]);
        $this->error404();
    }
}