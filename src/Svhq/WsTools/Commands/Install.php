<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliParser;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Phalcon\Di;

    class Install implements CliCommand {

        /**
         * @var int
         */
        private int $verbosity;

        public function __construct(CliParser $cliParser){
            $this->verbosity = intval($cliParser->getFlagValue('v') ?: 0);
            if($log = Di::getDefault()->get('debug')){
                $log->debug("wstools install");
            }
        }

        function execute(): ?int{
            return ExitCodes::OK;
        }
    }
}