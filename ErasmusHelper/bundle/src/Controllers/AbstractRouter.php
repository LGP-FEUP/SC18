<?php

namespace AgileBundle\Controllers;

use AgileBundle\Bundle;
use AgileBundle\Utils\Dbg;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use function FastRoute\cachedDispatcher;

/**
 * Class AbstractRouter
 * Simple MVCR router using FastRoute
 *
 * @package AgileBundle\Controllers
 */
#[Immutable]
abstract class AbstractRouter {

    /**
     * Domain used to build / recognize routes in the router
     *
     * @return string
     */
    protected abstract static function getDomain(): string;

    /**
     * The path from the domain to the slash in the routes information
     *
     * @important Must starts with slash and end without slash (if not empty)
     * @return string
     */
    protected abstract static function getRelativeDir(): string;

    /**
     * Default controller class called during errors in the routeReq method
     *
     * @return string
     */
    protected abstract static function getControllerClass(): string;

    /**
     * Retrieves the loaded route list for the Router
     *
     * @return array
     */
    #[ArrayShape([
        'routeId' => ["HTTP_METHOD", "RELATIVE_URL", [AbstractController::class, "controllerMethod"]]
    ])]
    protected abstract static function getRoutes(): array;

    /**
     * Compare the loadedRoutes with the actual http request and call corresponding controller if found, else throw
     * 40X errors.
     */
    public static function routeReq(): void {
        // First we initialize the FastRoute cachedDispatcher
        $routes = static::getRoutes();
        $dispatcher = cachedDispatcher(function (RouteCollector $r) use ($routes) {
            $dir = (static::getRelativeDir() ?? '');
            foreach ($routes as $routeId => $rt) {
                $r->addRoute($rt[0], $dir . $rt[1], [$rt[2], $routeId]);
            }
        }, [
            'cacheFile'     => Bundle::getInstance()->projectRoot . '/data/cache/routes_public.cache',
            'cacheDisabled' => is_dev(),
        ]);

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        // Then we dispatch it with httpMethod and uri
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                if (is_dev()) Dbg::error("Route not found for uri $uri");
                (new (static::getControllerClass()))->error404();
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                Dbg::error("Method $httpMethod not allowed for uri $uri");
                (new (static::getControllerClass()))->error405();
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                list($controller, $method) = $handler[0];
                $routeId = $handler[1];

                if (method_exists($controller, $method)) {
                    call_user_func_array([new $controller, $method], $vars);
                } else {
                    Dbg::error("Method $method not found in $controller");
                    (new (static::getControllerClass()))->error404();
                }
                break;
            default:
                Dbg::error("Unknown routeInfo type $routeInfo[0]");
                (new (static::getControllerClass()))->error404();
                break;
        }
    }

    /**
     * Build a route URL from the route id and parameters
     *
     * @param string $id
     * @param $vars
     * @return string
     */
    public static function route(string $id, $vars = []): string {
        $uri = static::getRoutes()[$id][1] ?? $id;
        $params = '';

        if (is_array($vars)) {
            foreach ($vars as $k => $v) {
                // On remplace les paramètres de la route par $var
                $uri = preg_replace('/{' . $k . ':?([a-zA-Z0-9-_.|+\\\]+)?}/', $v, $uri, -1, $count);
                if ($count > 0) {
                    unset($vars[$k]);
                }
            }
            if (!empty($var)) {
                $params = http_build_query($var);
            }
        } elseif (intval($vars) > 0) {
            // Si la variable est un int, on remplace simplement l'id présent dans la route
            $uri = preg_replace('/\{id:(.*)\}/', $vars, $uri);
        } else {
            $params = $vars;
        }

        if (!empty($params) && !str_contains($uri, '?') && !str_contains($params, '?')) {
            $params = "?" . $params;
        }

        return static::publicURL() . $uri . $params;
    }

    /**
     * Retourne l'URL publique de base du routeur
     *
     * @warning Cette URL n'est pas forcémment déservie par une route
     * @return string
     */
    #[Pure]
    private static function publicURL(): string {
        return static::getDomain() . static::getRelativeDir();
    }

    /**
     * Returns the URL for a local stored resource of the root project located in the public directory
     *
     * @param $type
     * @param $fileName
     * @return string
     */
    #[Pure]
    public static function resource($type, $fileName) : string {
        return static::publicURL() . "/assets/$type/$fileName";
    }

}
