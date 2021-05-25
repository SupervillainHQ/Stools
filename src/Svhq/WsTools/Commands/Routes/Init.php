<?php


namespace Svhq\WsTools\Commands\Routes {

    use Phalcon\Di;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\WsTools\Routing\RouteCollection;
    use Svhq\WsTools\Routing\RoutesFile;

    /**
     * Create a routes file
     * Class Init
     * @package Svhq\WsTools\Commands\Routes
     */
    class Init implements CliCommand {

        private string $filePath;

        public function __construct(string $filePath){
            $this->filePath = $filePath;
        }

        function execute(): ?int {
            $resMan = Di::getDefault()->getResource($this->filePath);
            $routes = new RoutesFile();
            $defaultCollection = RouteCollection::inflate((object) ['prefix' => '']);
            $routes->pushRouteCollection($defaultCollection);
            $buffer = json_encode($routes);
            $resMan->write($buffer, true);
            return ExitCodes::OK;
        }
    }
}