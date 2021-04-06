<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;

    /**
     * Class Disable. Unlink web server config symlink from sites-enabled/
     * @package Svhq\WsTools\Commands
     */
    class Disable implements CliCommand {

        function execute(): ?int{
            return ExitCodes::GENERIC_ERROR;
        }
    }
}