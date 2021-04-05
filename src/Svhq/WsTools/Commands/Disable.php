<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;

    class Disable implements CliCommand {

        function execute(): ?int{
            return ExitCodes::GENERIC_ERROR;
        }
    }
}