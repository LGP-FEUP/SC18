<?php

namespace ErasmusHelper\Controllers;

abstract class CityModsBackOfficeController extends BackOfficeController {

    protected int $requirePrivilege = CITYMODERATORS_PRIVILEGES;

    public function __construct() {
        parent::__construct();
        $this->requirePrivileges();
    }
}