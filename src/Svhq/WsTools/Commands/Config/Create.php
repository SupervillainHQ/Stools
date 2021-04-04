<?php


namespace Svhq\WsTools\Commands\Config {


    use Phalcon\Di;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\WsTools\Web\Server\Apache\ApacheConfig;
    use Svhq\WsTools\Web\Server\Apache\ApacheService;

    class Create implements CliCommand {

        private int $verbosity;
        private string $domain;
        private string $targetPath;

        public function __construct(string $domain, string $targetPath = null, int $verbosity = 0){
            $this->domain = $domain;
            $this->verbosity = $verbosity;

            if(!$targetPath){
                $targetPath = ApacheService::defaultConfigDirectory();
            }
            $this->targetPath = $targetPath;

            if($log = Di::getDefault()->get('debug')){
                $log->debug("wstools install");
            }
        }

        function execute(): ?int{
            $basePath = '/var/www';
            $docRoot = "{$basePath}/{$this->domain}/public";
            $cfgData = (object) [
                'serverName' => $this->domain,
                'documentRoot' => $docRoot,
                'errorLog' => "{$basePath}/{$this->domain}/logs/errors.log",
                'accessLog' => "\${APACHE_LOG_DIR}/log/access.log",
            ];
            $apacheCfg = new ApacheConfig($cfgData);
            $buffer = $apacheCfg->save();
            echo $buffer;
            return ExitCodes::OK;
        }
    }
}