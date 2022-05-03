<?php

namespace AgileBundle\Controllers;

use JetBrains\PhpStorm\NoReturn;

/**
 * Class Controller
 * Generic MVC controller
 *
 * @package AgileBundle\Controllers
 */
abstract class AbstractController {

    /**
     * Send JSON headers with a success payload
     *
     * @param string $message
     * @param array $data
     */
    #[NoReturn] protected function jsonSuccess($message = "OK", $data = []){
        $this->json(["status" => "success", "message" => $message, "data" => $data], 200);
    }

    /**
     * Send JSON headers with an error payload
     *
     * @param string $message
     * @param int $code
     */
    #[NoReturn] protected function jsonError($message = "Error", $code = 400){
        $this->json(["status" => "error", "message" => $message], $code);
    }

    /**
     * Send JSON headers with custom payload
     *
     * @param $data
     * @param $status
     */
    #[NoReturn] protected function json($data, $status){
        if(!headers_sent()){
            http_response_code($status);
            header('Content-Type: application/json');
        }
        echo (json_encode($data));
        exit();
    }

    /**
     * Throw a 401 error, change the header to HTTP 401: Unauthorized
     */
    public function error401() {
        header('HTTP/1.0 401 Unauthorized');
    }

    /**
     * Throw a 403 error, change the header to HTTP 403: Forbidden
     */
    public function error403() {
        header('HTTP/1.0 403 Forbidden');
    }

    /**
     * Throw a 404 error, change the header to HTTP 404: Not Found
     */
    public function error404() {
        header('HTTP/1.0 404 Not Found');
    }

    /**
     * Throw a 405 error, change the header to HTTP 405: Method not allowed
     */
    public function error405() {
        header('HTTP/1.0 405 Method not allowed');
    }

}
