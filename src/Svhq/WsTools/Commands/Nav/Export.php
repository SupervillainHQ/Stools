<?php


namespace Svhq\WsTools\Commands\Nav {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;

    /**
     * Output a site map structure. In order to not dictate how site navigation structures should look like, this part of the
     * WS-tools should only be concerned about transforming content-structures into well-known formats (json?).
     * Maybe analyse a routes file?
     * Class Export
     * @package Svhq\WsTools\Commands\Nav
     */
    class Export implements CliCommand {

        function execute(): ?int{
            return ExitCodes::NOT_IMPLEMENTED;
        }
    }
}