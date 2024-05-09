<?php

declare(strict_types=1);

namespace Router;

class Router
{
    protected $routes = []; // хронение роутов

    /**
     * один пост
     *
     * @param string $method
     * @param string $url
     * @param callable $target
     *
     *
     *  @return void
     */
    public function addRoute(string $method, string $url, callable $target) : void
    {
        $this->routes[$method][$url] = $target;
    }

    /**
     * проверка на совпадение роутов
     *
     * @param string $method
     * @param string $url
     * @param callable $target
     *
     *
     *  @return void
     */
    public function matchRoute() : void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // Use named subpatterns in the regular expression pattern to capture each parameter value separately
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    // Pass the captured parameter values as named arguments to the target function
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY); // Only keep named subpattern matches
                    call_user_func_array($target, $params);
                    return;
                }
            }
        }
        echo 'Такой страницы нет!!!!';
    }
}