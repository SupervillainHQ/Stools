<?php


namespace Svhq\WsTools\Routing;


class Route implements \JsonSerializable {
    protected string $name;
    protected string $method;
    protected string $path;
    protected string $action;

    public static function inflate($data):Route{
        $instance = new Route();
        if(property_exists($data, 'name')){
            $instance->name = trim($data->name);
        }
        if(property_exists($data, 'method')){
            $instance->method = trim($data->method);
        }
        if(property_exists($data, 'path')){
            $instance->path = trim($data->path);
        }
        if(property_exists($data, 'action')){
            $instance->action = trim($data->action);
        }
        return $instance;
    }

    public function jsonSerialize() {
        return (object) [
            'name' => $this->name,
            'method' => $this->method,
            'path' => $this->path,
            'action' => $this->action
        ];
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function action(): string
    {
        return $this->action;
    }
}