<?php

namespace ErasmusHelper\Controllers;

abstract class BackOfficeController extends Controller {

    protected bool $requireAuth = true;
    protected string $layout = "backoffice";

}