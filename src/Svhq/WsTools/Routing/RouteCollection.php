<?php


namespace Svhq\WsTools\Routing;


class RouteCollection implements \JsonSerializable, \Iterator, \ArrayAccess {

    protected string $prefix;
    protected string $controllerClass;
    protected array $routes;
    private int $index = 0;

    public static function inflate($data):RouteCollection{
        $instance = new RouteCollection();
        if(property_exists($data, 'prefix')){
            $instance->prefix = trim($data->prefix);
        }
        if(property_exists($data, 'class')){
            $instance->controllerClass = trim($data->class);
        }
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
    public function prefix(): string {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix = ''): void{
        $this->prefix = trim($prefix);
    }

    public function offsetExists($offset){
        return array_key_exists($offset, $this->routes);
    }

    public function offsetGet($offset){
        return $this->routes[$offset];
    }

    public function offsetSet($offset, $value){
        $this->routes[$offset] = $value;
    }

    public function offsetUnset($offset){
        unset($this->routes[$offset]);
    }

    public function current()
    {
        return $this->routes[$this->index];
    }

    public function next()
    {
        $this->index++;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return isset($this->routes[$this->index]);
    }

    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * @return string
     */
    public function controllerClass(): string{
        return $this->controllerClass;
    }

    /**
     * @param string $classPath
     */
    public function setControllerClass(string $classPath): void{
        $this->controllerClass = $classPath;
    }
}