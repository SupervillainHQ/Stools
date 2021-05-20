<?php


namespace Svhq\WsTools {

    use Svhq\Core\Annotations\Cli\CliAnnotationsProcessor;
    use Svhq\Core\Application\CliApplication;
    use Svhq\Core\Cli\CliParser;
    use Svhq\Core\Cli\Console;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Cli\CliCommand;

    class WsToolsCliApplication extends CliApplication {

        protected function initCommand():?CliCommand{
            $cliParser = CliParser::instance();
            try{
                $namespace = "Svhq\\WsTools\\Commands";
                if($commandClass = CliParser::getCommandClass($namespace)){

                    $reflector = new \ReflectionClass($commandClass);
                }
//                $className = ucfirst($wsCommand);
//                $commandClass = "{$namespace}\\{$className}";
            }
            catch (\Exception $exception){
                $wsCommand = '';
            }

            if(isset($commandClass)){
                if (isset($reflector) && $reflector->implementsInterface(CliCommand::class)) {
                    // evaluate aliases, commandline argument validation and other meta-logic via annotations
                    $processor = new CliAnnotationsProcessor($commandClass);
                    try {
                        $processor->process();
                    }
                    catch (\Exception $exception) {
                        Console::instance()->log("Failed to evaluate sub-command and/or arguments: <red>{$exception->getMessage()}</red>");
                        exit(ExitCodes::GENERIC_ERROR);
                    }

                    if ($reflector->hasMethod('__construct')) {
                        $ctor = $reflector->getMethod('__construct');
                        $parameters = $ctor->getParameters();
                        // params sorted so the argument values, passed via the commandline, matches the required constructor
                        // parameters, in the correct order
                        try{
                            $params = CliParser::mergeParameters($parameters);
                            if (!empty($params)) {
                                $commandInstance = $reflector->newInstanceArgs($params);
                            }
                            else {
                                $commandInstance = $reflector->newInstance();
                            }
                        }
                        catch (\Exception $exception){
                            Console::instance()->log("Failed to align command <b>{$commandClass}</b> parameters with supplied arguments: <red>{$exception->getMessage()}</red>");
                            exit(ExitCodes::GENERIC_ERROR);
                        }
                    }
                    else {
                        try{
                            $commandInstance = $reflector->newInstance();
                        }
                        catch (\Exception $exception){
                            Console::instance()->log("Failed to instantiate command <b>{$commandClass}</b>: <red>{$exception->getMessage()}</red>");
                            exit(ExitCodes::GENERIC_ERROR);
                        }
                    }
                    if($commandInstance instanceof CliCommand){
                        return $commandInstance;
                    }
                }
            }
            return null;
        }

        protected function commandNamespaces(): array {
            return ["Svhq\\WsTools\\Commands"];
        }
    }
}