<?php


namespace Svhq\WsTools\Commands\Config {


    use Phalcon\Di;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Resource\ResourceManager;
    use Svhq\WsTools\Web\Server\Apache\ApacheConfig;
    use Svhq\WsTools\Web\Server\Apache\ApacheService;

    class Create implements CliCommand {

        private int $verbosity;
        private string $domain;
        private string $targetPath;
        private ResourceManager $resourceManager;

        public function __construct(string $domain, string $targetPath = null, int $verbosity = 0){
            $this->domain = $domain;
            $this->verbosity = $verbosity;
            $this->targetPath = is_null($targetPath) ? ApacheService::defaultConfigDirectory() : $targetPath;

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
            if(!isset($this->resourceManager)){
                echo $apacheCfg->save();
                return ExitCodes::OK;
            }
            $apacheCfg->save($this->resourceManager);
            return ExitCodes::OK;
        }

        /**
         * @return ResourceManager
         */
        public function resourceManager(): ResourceManager
        {
            return $this->resourceManager;
        }

        /**
         * @param ResourceManager $resourceManager
         */
        public function setResourceManager(ResourceManager $resourceManager): void
        {
            $this->resourceManager = $resourceManager;
        }
    }
}