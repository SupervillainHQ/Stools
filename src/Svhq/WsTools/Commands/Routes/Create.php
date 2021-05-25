<?php

namespace Svhq\WsTools\Commands\Routes {

    use Phalcon\Di;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\WsTools\Routing\Route;
    use Svhq\WsTools\Routing\RoutesFile;

    /**
     * Create a route in a designated routes file
     * Class Create
     * @package Svhq\WsTools\Commands\Routes
     */
    class Create implements CliCommand {

        private string $routesFilePath;
        private string $name;
        private string $collectionPrefix;

        public function __construct(string $routesFilePath, string $name, string $collectionPrefix = '', string $path = '', string $method = null) {
            $this->routesFilePath = $routesFilePath;
            $this->name = $name;
            $this->collectionPrefix = $collectionPrefix;
        }

        function execute(): ?int {
            $data = (object) [
                'name' => $this->name
            ];
            $route = Route::inflate($data);
            $resMan = Di::getDefault()->getResource($this->routesFilePath);
            $raw = $resMan->read();
            $routesFile = RoutesFile::inflate($raw);
            if($collection = $routesFile->getCollection($this->collectionPrefix)){
                $collection->addRoute($route);
            }
            $buffer = $routesFile->jsonSerialize();
            $resMan->write($buffer);
//            foreach ($json as $collections) {
//                if($collections->prefix == $this->collectionPrefix){
//                    $collections->addRoute($route);
//                }
//            }
            return ExitCodes::NOT_IMPLEMENTED;
        }
    }
}