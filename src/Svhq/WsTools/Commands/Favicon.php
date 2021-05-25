<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Incubation\Cli\ParentCommand;
    use Svhq\WsTools\Commands\Favicon\Create;

    class Favicon extends ParentCommand implements CliCommand {

        function execute(): ?int {
            switch ($this->subCommand){
                case 'create':
                    $subCommand = new Create();
                    return $subCommand->execute();
            }
            return ExitCodes::NOT_IMPLEMENTED;
        }
    }
}