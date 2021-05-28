<?php

namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Incubation\Cli\ParentCommand;
    use Svhq\WsTools\Commands\Mongo\InitService;

    class Mongod extends ParentCommand implements CliCommand {
        const SUB_INIT = 'init';

        function execute(): ?int{
            switch ($this->subCommand){
                case self::SUB_INIT:
                    $sub = new InitService();
                    return $sub->execute();
            }
            return ExitCodes::GENERIC_ERROR;
        }
    }
}