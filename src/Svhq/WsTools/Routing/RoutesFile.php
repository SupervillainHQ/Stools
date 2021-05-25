<?php


namespace Svhq\WsTools\Routing;


use Phalcon\Di;
use Svhq\Core\Resource\FileResource;
use Svhq\Core\Resource\ResourceManager;

class RoutesFile implements \JsonSerializable, \Serializable {

    protected array $routeCollections;

    public function __construct() {
        $this->resetRouteCollections();
    }

    public static function load($filePath):?RoutesFile{
        $resMan = Di::getDefault()->getResource($filePath);
        if($resMan instanceof ResourceManager){
            $resMan->read($raw);
            if($routesFile = RoutesFile::inflate($raw)){
                return $routesFile;
            }
        }
        return null;
    }

    public static function inflate($data):RoutesFile{
        $instance = new RoutesFile();
        $instance->unserialize($data);
        return $instance;
    }

    public function jsonSerialize(){
        return $this->routeCollections;
    }

    public function resetRouteCollections(array $collections = []):void{
        $this->routeCollections = $collections;
    }

    public function pushRouteCollection(RouteCollection $collection):void{
        array_push($this->routeCollections, $collection);
    }

    public function popRouteCollection():?RouteCollection{
        return array_pop($this->routeCollections);
    }

    public function getCollection(string $prefix = ''):?RouteCollection{
        foreach ($this->routeCollections as $collection){
            if($collection->prefix() == $prefix){
                return $collection;
            }
        }
        return null;
    }

    public function serialize()
    {
        return json_encode($this);
    }

    public function unserialize($data)
    {
        $this->resetRouteCollections();
        $collections = json_decode($data);
        foreach($collections as $collectionData){
            $collection = RouteCollection::inflate($collectionData);
            $this->pushRouteCollection($collection);
        }
    }

    public function collections(): array{
        return $this->routeCollections;
    }
}