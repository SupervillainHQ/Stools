<?php


namespace Svhq\WsTools\Commands\Mongo {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\CliParser;
    use Svhq\Core\Cli\Console;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Config\Config;
    use Svhq\WsTools\WsToolsCliApplication;

    class InitService implements CliCommand{

        function execute(): ?int{
            $db = CliParser::instance()->getArgumentValue('database');
            if(!strlen($db)){
                Console::instance()->log("Database missing");
                return ExitCodes::INVALID_ARGUMENT;
            }

            $key = WsToolsCliApplication::instance()->key();
            if($initScriptPath = Config::instance($key)->absolutePath('./scripts/mongo/init-mongo.sh')){
                $escDb = escapeshellarg($db);
                $bashCmd = "bash {$initScriptPath} {$escDb}";
                Console::instance()->log("Command: {$bashCmd}");
                exec($bashCmd, $out, $result);
                Console::instance()->log("Result: {$result}");
                Console::instance()->log("Output:");
                foreach ($out as $string) {
                    Console::instance()->log("  {$string}");
                }
            }
            return ExitCodes::OK;
        }
    }
}