<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;

abstract class BackOfficeController extends Controller {

    protected bool $requireAuth = true;
    protected string $layout = "backoffice";

}