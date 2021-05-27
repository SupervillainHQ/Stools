<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\CliParser;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Config\Config;
    use Svhq\Incubation\Cli\ParentCommand;
    use Svhq\WsTools\Commands\Routes\Status;

    class Routes extends ParentCommand implements CliCommand {

        function execute(): ?int{
            switch ($this->subCommand){
                case 'status':
                    $filePath = CliParser::instance()->getArgumentValue('file') ?? '{PROJECT}/config/routes.json';
                    $absFilePath = Config::absolutePath($filePath);
                    $subCommand = new Status($absFilePath);
                    return $subCommand->execute();
            }
            return ExitCodes::NOT_IMPLEMENTED;
        }
    }
}