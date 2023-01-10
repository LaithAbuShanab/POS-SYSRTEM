<?php

namespace Core;

/**
 * MANAGES THE ROUTING PROCESS IN THE APPLICATION
 */
class Router
{
    // GET requests
    protected static $get_routes = array();
    // POST requests
    protected static $post_routes = array();
    // PUT requests
    protected static $put_routes = array();
    // DELETE requests
    protected static $delete_routes = array();

    public static function redirect(): void
    {

        $request = $_SERVER['REQUEST_URI'];
        $request = \explode("?", $request)[0];
        $routes = array();

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $routes = self::$get_routes;
                break;
            case 'POST':
                $routes = self::$post_routes;
                break;
            case 'PUT':
                $routes = self::$put_routes;
                break;
            case 'DELETE':
                $routes = self::$delete_routes;
                break;
        }

        if (empty($routes) || !array_key_exists($request, $routes)) {
            var_dump("no found");
            http_response_code(404);
            exit;
        }


        $controller_namespace = 'Core\\Controller\\';
        $class_arr = explode('.', $routes[$request]);
        $class_name = ucfirst($class_arr[0]);
        $class = $controller_namespace . $class_name;

        $instance = new $class;

        if (count($class_arr) == 2) {
            call_user_func([$instance, $class_arr[1]]);
        }

        $instance->render();
    }

    public static function get($route, $controller): void
    {
        self::$get_routes[$route] = $controller;
    }

    public static function post($route, $controller): void
    {
        self::$post_routes[$route] = $controller;
    }

    public static function put($route, $controller): void
    {
        self::$put_routes[$route] = $controller;
    }

    public static function delete($route, $controller): void
    {
        self::$delete_routes[$route] = $controller;
    }
}
