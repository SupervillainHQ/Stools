<?php


namespace Svhq\WsTools {

    use Svhq\Core\Cli\CliParser;
    use Svhq\Incubation\CliApplication;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\WsTools\Commands\Install;

    class WsToolsCliApplication extends CliApplication{

        protected function initCommand():?CliCommand{
            $cliParser = CliParser::instance();
            try{
                $wsCommand = $cliParser->getCommand(0)->value();
            }
            catch (\Exception $exception){
                $wsCommand = '';
            }
            switch (strtolower($wsCommand)){
                case 'install':
                    return new Install($cliParser);
            }
        }
    }
}