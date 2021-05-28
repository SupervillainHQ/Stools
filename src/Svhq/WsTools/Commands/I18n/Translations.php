<?php


namespace Svhq\WsTools\Commands\I18n {

    use Phalcon\Di;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\CliParser;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Config\Config;
    use Svhq\Incubation\Cli\ParentCommand;

    class Translations extends ParentCommand implements CliCommand{

        function execute(): ?int{
            switch ($this->subCommand){
                case 'export':
                    $labels = (object) [];

                    $outputFilePath = CliParser::instance()->getArgumentValue('out');
                    $outputFilePathResolved = Config::instance()->absolutePath($outputFilePath, true);

                    $resMan = Di::getDefault()->getResource($outputFilePathResolved);
                    $resMan->write(json_encode($labels), true);
                    return ExitCodes::OK;
            }
            return ExitCodes::NOT_IMPLEMENTED;
        }
    }
}