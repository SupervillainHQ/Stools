<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\Console;
    use Svhq\Core\Cli\ExitCodes;

    class Status implements CliCommand {

        function execute(): ?int {
            Console::instance()->log("STATUS: OK");
            return ExitCodes::GENERIC_ERROR;
        }
    }
}