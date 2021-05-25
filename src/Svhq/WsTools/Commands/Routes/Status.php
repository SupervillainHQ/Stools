<?php


namespace Svhq\WsTools\Commands\Routes {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\Console;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\WsTools\Routing\RoutesFile;

    class Status implements CliCommand {

        private string $routesFilePath;
        private string $prefix;

        public function __construct(string $routesFilePath, string $prefix = '') {
            $this->routesFilePath = $routesFilePath;
            $this->prefix = $prefix;
        }

        function execute(): ?int {
            $routesFile = RoutesFile::load($this->routesFilePath);

            if(!is_null($this->prefix)){
                $prefix = "'{$this->prefix}'";
                Console::instance()->log("Collection[{$prefix}]:");
                if($collection = $routesFile->getCollection($this->prefix)){
                    foreach ($collection as $route) {
                        Console::instance()->log("Route[name: {$route->name()}, method: {$route->method()}, path: {$route->path()}, action: {$route->action()}]");
                    }
                }
                return ExitCodes::OK;
            }
            foreach ($routesFile->collections() as $collection){
                Console::instance()->log('Collection');
                foreach ($collection as $routes) {
                    Console::instance()->log('Route');
                }
            }
            return ExitCodes::OK;
        }
    }
}