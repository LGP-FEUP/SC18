<?php

namespace ErasmusHelper\Controllers;

/**
 * If a controller extends from this class it requires the user to be admin to access its content.
 * This will block all routes calling this controller if the user is not admin.
 */
abstract class UniModsBackOfficeController extends BackOfficeController {

    protected int $requirePrivilege = UNIMODERATORS_PRIVILEGES;

    public function __construct() {
        parent::__construct();
        $this->requirePrivileges();
    }
}