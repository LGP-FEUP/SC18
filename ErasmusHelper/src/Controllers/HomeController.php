<?php

namespace ErasmusHelper\Controllers;

class HomeController extends Controller {


    public function home(): void {
        //$this->render("generic.test");
        //$this->redirect(Router::route("countries", ["id" => 1]), ["error" => "Unallowed."]);
        $this->error404();
    }
}