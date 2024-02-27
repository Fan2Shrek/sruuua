<?php

namespace Sruuua\Routing;

use Sruuua\Routing\Route;

class Router
{
    /**
     * @var array list of all routes
     */
    private array $routeList = [];

    public function __construct()
    {
        Route::setRouter($this);
    }

    /**
     * Route adder
     * 
     * @param Route $route
     * 
     * @return void
     */
    public function addRoute(Route $route)
    {
        $this->routeList[$route->getPath()] = $route;
    }

    /**
     * Return the formatted route with args
     * 
     * @param string $path the path of the route
     * 
     * @return Route The route object of given path
     */
    public function getRoute(string $path): ?Route
    {

        $try = $this->routeList[$path] ?? null;

        if (null !== $try) {
            return $try;
        }

        foreach ($this->routeList as $route) {
            preg_match("/\{.+\}/", $route->getPath(), $match);

            if (!empty($match)) {
                $possibleRoute = explode('/', $route->getPath());
                $request = explode('/', $path);

                if (count($request) !== count($possibleRoute)) {
                    continue;
                }

                $maybeRoute = '';

                for ($i = 1; $i < count($request); $i++) {
                    if (str_contains($possibleRoute[$i], '{') && str_contains($possibleRoute[$i], '}')) {
                        $maybeRoute .= '/' . $possibleRoute[$i];
                        $format = str_replace('{', '', $possibleRoute[$i]);
                        $format = str_replace('}', '', $format);
                        $route->ModifyOption([$format, $request[$i]]);

                        if (isset($this->routeList[$maybeRoute])) {

                            return $route;
                        }
                    } elseif ($possibleRoute[$i] === $request[$i]) {
                        $maybeRoute .= '/' . $request[$i];
                        continue;
                    } else {
                        break;
                    }
                }
            }
        }

        return null;
    }
}
