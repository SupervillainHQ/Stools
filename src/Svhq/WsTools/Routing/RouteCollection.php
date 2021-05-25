<?php


namespace Svhq\WsTools\Routing;


class RouteCollection implements \JsonSerializable {

    protected string $prefix;
    protected string $controllerClass;
    protected array $routes;

    public static function inflate($data):RouteCollection{
        $instance = new RouteCollection();
        $instance->prefix = trim($data->prefix);
        $instance->controllerClass = trim($data->class);
        $instance->routes = [];

        foreach ($data->routes as $routeData) {
            $route = Route::inflate($routeData);
            array_push($instance->routes, $route);
        }
        return $instance;
    }


    public function jsonSerialize() {
        return (object) [
            'prefix' => $this->prefix,
            'class' => $this->controllerClass,
            'routes' => $this->routes,
        ];
    }

    /**
     * @return string
     */
    public function prefix(): string
    {
        return $this->prefix;
    }
}