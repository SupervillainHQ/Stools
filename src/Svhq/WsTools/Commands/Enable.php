<?php


namespace Svhq\WsTools\Commands {


    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;

    /**
     * Class Enable. Establish a web server config symlink in sites-enabled/
     * @package Svhq\WsTools\Commands
     */
    class Enable implements CliCommand {

        private string $domain;
        private string $configFile;

        public function __construct(string $domain, string $configFile = null, int $verbosity = 0){
            $this->domain = $domain;
            $this->configFile = is_null($configFile) ? '' : $configFile;
        }

        function execute(): ?int{
            return ExitCodes::GENERIC_ERROR;
        }
    }
}