<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;

    /**
     * Class Delete. Delete a web site installation
     * @package Svhq\WsTools\Commands
     */
    class Delete implements CliCommand {

        function execute(): ?int{
            return ExitCodes::GENERIC_ERROR;
        }
    }
}