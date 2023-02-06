<?php

namespace Ivrok\WPAPIRouter;

use Ivrok\WPAPIRouter\Exceptions\IncorrectHTTPMethod;

class WPAPIRoute
{
    public $method;
    public $namespace;
    public $path;
    private $callback;

    public function __construct(string $method, string $namespace, string $path, callable $callback)
    {
        $this->checkMethod($method);

        $this->method = $method;
        $this->namespace = $namespace;
        $this->path = $path;
        $this->callback = $callback;
    }

    public function call(\WP_REST_Request $request)
    {
        call_user_func_array($this->callback, [$request]);
    }

    private function checkMethod($method)
    {
        if (!in_array($method, HTTPMethodsInterface::METHODS)) {
            throw new IncorrectHTTPMethod(sprintf("The method %s is incorrect, it should be one of next ones: %s.",
            $method, implode(", ", HTTPMethodsInterface::METHODS)));
        }
    }
}
