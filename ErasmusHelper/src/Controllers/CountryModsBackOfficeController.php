<?php

namespace ErasmusHelper\Controllers;

abstract class CountryModsBackOfficeController extends BackOfficeController {

    protected int $requirePrivilege = COUNTRYMODERATORS_PRIVILEGES;

    public function __construct() {
        parent::__construct();
        $this->requirePrivileges();
    }
}