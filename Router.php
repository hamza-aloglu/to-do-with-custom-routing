<?php

declare(strict_types=1);

namespace todo;


class Router
{
    public array $routes;

    private function register(string $reqMethod, string $route, callable|array $action) : self
    {
        $this->routes[$reqMethod]['/to-do/to-do' . $route] = $action;
        return $this;
    }

    public function get(string $route, callable|array $action) : self
    {
        return $this->register('get', $route, $action);
    }
    public function post(string $route, callable|array $action) : self
    {
        return $this->register('post', $route, $action);
    }

    public function resolve(string $requestUri, string $reqMethod, $classArgs = null)
    {
        $route =  explode('?', $requestUri)[0];
        $action = $this->routes[$reqMethod][$route] ?? null;


        if (is_callable($action))
        {
            return $action();
        }
        if (is_array($action))
        {
            [$class, $method] = $action;
            if (class_exists($class))
            {
                $class = new $class($classArgs);
                if (method_exists($class, $method))
                {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }
        throw new \Exception('cannot be resolved.');

    }
}

