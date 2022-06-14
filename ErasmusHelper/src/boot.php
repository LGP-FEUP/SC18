<?php

use AgileBundle\Bundle;

define('APPLICATION_PATH', realpath(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR));
require_once(APPLICATION_PATH . "/vendor/autoload.php");

session_start();

require_once(APPLICATION_PATH . "/conf.inc.php");
require_once ("helpers.php");

(new Bundle(
    projectRoot: APPLICATION_PATH,
    isDev: IS_DEV,
    dbgPrefix: "ErasmusHelper"
));