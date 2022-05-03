<?php

namespace AgileBundle\Controllers;

use JetBrains\PhpStorm\NoReturn;

/**
 * Class AbstractAPIController
 * MVC API controller
 *
 * @package AgileBundle\Controllers
 */
abstract class AbstractAPIController extends AbstractController {

    /**
     * @inheritDoc
     */
    #[NoReturn] public function error401() {
        parent::error401();
        $this->jsonError("Unauthorized error 401", 401);
    }

    /**
     * @inheritDoc
     */
    #[NoReturn] public function error403() {
        parent::error403();
        $this->jsonError("Forbidden error 403", 403);
    }

    /**
     * @inheritDoc
     */
    #[NoReturn] public function error404() {
        parent::error404();
        $this->jsonError("Not found error 404", 404);
    }

    /**
     * @inheritDoc
     */
    #[NoReturn] public function error405() {
        parent::error405();
        $this->jsonError("Method not allowed error 405", 405);
    }

}
