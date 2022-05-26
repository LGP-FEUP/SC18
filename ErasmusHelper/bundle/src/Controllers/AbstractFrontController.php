<?php

namespace AgileBundle\Controllers;

use AgileBundle\Bundle;
use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;

/**
 * Class AbstractFrontController
 * MVC front controller
 *
 * @package AgileBundle\Controllers
 */
abstract class AbstractFrontController extends AbstractController {

    /**
     *
     */
    private const SESSION_ALERT = 'alert';

    /**
     * Layout of the controller in which views will be rendered
     *
     * @var string
     */
    protected string $layout = 'master';

    /**
     * Defines if the controller have been called in async mode or in sync mode (ajax)
     *
     * @var bool
     */
    protected bool $async = false;

    /**
     * Sets the title for this controller.
     *
     * @var string
     */
    protected string $title = "";

    /**
     * Render the given view in the controller layout with the given vars
     *
     * @param $view
     * @param array $vars
     */
    protected function render(string $view, array $vars = []) {
        if(!empty($this->title)) {
            $vars["title"] = $this->title;
        }
        $content = $this->getContent($view, $vars);
        if ($this->async || is_null($this->layout)) {
            echo $content;
            exit();
        }
        if (isset($_SESSION[self::SESSION_ALERT])) {
            $vars["alert"] = $_SESSION[self::SESSION_ALERT];
            unset($_SESSION[self::SESSION_ALERT]);
        }
        extract($vars);
        include $this->getViewPath("layouts/$this->layout");
    }

    /**
     * Retrieve the content of a view with the given vars
     *
     * @param string $view
     * @param array $vars
     * @return string
     */
    protected function getContent(string $view, array $vars = []): string {
        ob_start();
        extract($vars);
        include $this->getViewPath($view);
        return ob_get_clean();
    }

    /**
     * Redirect the connected client to the specified url with the given HTTP Code
     *
     * @param string $url
     * @param array $alert
     * @param int $status HTTP Code
     */
    #[NoReturn] public function redirect(string $url, array $alert = [], int $status = 302) {
        $_SESSION[self::SESSION_ALERT] = $alert;
        header('Location: ' . $url, true, $status);
        session_write_close();
        exit();
    }

    /**
     * Retrieve the views folder path
     *
     * @return string
     */
    #[Pure] public function getViewsFolder(): string {
        return Bundle::getInstance()->projectRoot . "/views";
    }

    /**
     * Retrieve the view file path from the view name
     *
     * @param string $view
     * @return string
     */
    public function getViewPath(string $view): string {
        $viewFormatted = str_replace('.', '/', $view);
        return $this->getViewsFolder() . "/$viewFormatted.htm.php";
    }

    /**
     * @inheritDoc
     */
    public function error401() {
        parent::error401();
        if ($this->async) {
            $this->jsonError("Unauthorized error 401", 401);
        } else {
            $this->render('generic.401');
        }
    }

    /**
     * @inheritDoc
     */
    public function error403() {
        parent::error403();
        if ($this->async) {
            $this->jsonError("Forbidden error 403", 403);
        } else {
            $this->render('generic.403');
        }
    }

    /**
     * @inheritDoc
     */
    public function error404() {
        parent::error404();
        if ($this->async) {
            $this->jsonError("Not found error 404", 404);
        } else {
            $this->render('generic.404');
        }
    }

    /**
     * @inheritDoc
     */
    public function error405() {
        parent::error405();
        if ($this->async) {
            $this->jsonError("Method not allowed error 405", 405);
        } else {
            $this->render('generic.405');
        }
    }

}
