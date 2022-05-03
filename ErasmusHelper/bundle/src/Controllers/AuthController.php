<?php

namespace AgileBundle\Controllers;

/**
 * Trait AuthController
 * Add an authentification system to a controller
 *
 * @package AgileBundle\Controllers
 */
trait AuthController {

    /**
     * Represents the connected user in the HTTP Request.
     * The way we find the connected user depends off the project and is defined in abstract method auth
     *
     * @var mixed|null
     */
    protected mixed $user = null;

    /**
     * Defines whether the controller can be called without any kind of authentification or not
     *
     * @var bool
     */
    protected bool $requireAuth = false;

    /**
     * Controller constructor.
     * If requireAuth is at true, the controller will try to auth using abstract
     * method auth, if after the authentification the
     * controller user is null, a 401 error will be thrown
     */
    public function __construct() {
        if($this->requireAuth){
            $this->auth();
            if($this->user == null){
                $this->error401();
            }
        }
    }

    /**
     * Update the user field depending on the actual context of the application and of the HTTP request
     */
    protected abstract function auth();

}
