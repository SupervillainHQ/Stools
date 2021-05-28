<?php

namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\Console;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Config\Config;
    use Svhq\Incubation\Cli\ParentCommand;
    use Svhq\WsTools\WsToolsCliApplication;

    class Mongod extends ParentCommand implements CliCommand {
        const SUB_INIT = 'init';

        function execute(): ?int{
            switch ($this->subCommand){
                case self::SUB_INIT:
                    // TODO: execute bash init-script
                    $key = WsToolsCliApplication::instance()->key();
                    if($initScriptPath = Config::instance($key)->absolutePath('./scripts/mongo/test.sh')){
                        $db = 'wstools';
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
                    return ExitCodes::NOT_IMPLEMENTED;
            }
            return ExitCodes::GENERIC_ERROR;
        }
    }
}