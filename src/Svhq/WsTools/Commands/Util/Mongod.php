<?php

namespace Svhq\WsTools\Commands\Util {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;

    class Mongod implements CliCommand {
        const SUB_INIT = 'init';

        private string $subCommand;

        public function __construct(string $database) {
            $this->subCommand = '';
        }

        function execute(): ?int{
            switch ($this->subCommand){
                case self::SUB_INIT:
                    // TODO: execute bash init-script
                    return ExitCodes::NOT_IMPLEMENTED;
            }
            return ExitCodes::GENERIC_ERROR;
        }
    }
}