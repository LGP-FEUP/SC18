<?php

namespace ErasmusHelper\Controllers;

use ErasmusHelper\App;

/**
 * If a controller extends from this class it requires the user to be admin to access its content.
 * This will block all routes calling this controller if the user is not admin.
 */
abstract class AdminBackOfficeController extends BackOfficeController {

    protected int $requirePrivilege = ADMIN_PRIVILEGES;

    public function __construct() {
        parent::__construct();
        $this->requirePrivileges();
    }
}