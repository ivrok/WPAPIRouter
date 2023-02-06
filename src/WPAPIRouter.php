<?php

namespace Ivrok\WPAPIRouter;

class WPAPIRouter
{
    private $routes = [];

    public function addRoute(WPAPIRoute $route): void
    {
        $this->routes[] = $route;
    }

    public function init()
    {
        add_action('rest_api_init', [$this, "__restApiInit"]);
    }

    public function __restApiInit()
    {
        foreach ($this->routes as $route) {
            register_rest_route( $route->namespace, $route->path, [
                'methods' => $route->method,
                'callback' => [$route, 'call'],
            ]);
        }
    }
}
