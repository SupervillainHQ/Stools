<?php


namespace Svhq\WsTools\Web\Server\Apache {

    use Svhq\Core\Inflatable;
    use Svhq\Core\Inflated;
    use Svhq\Core\Inflating;
    use Svhq\Core\Resource\ResourceManager;
    use Svhq\WsTools\Web\WebConfig;

    class ApacheConfig extends Inflated implements WebConfig {

        use Inflating;

        protected string $serverName;
        protected string $documentRoot;
        protected string $errorLog;
        protected string $accessLog;
        /**
         * @var \JsonSerializable[]
         */
        protected array $directories;
        /**
         * @var ApacheService
         */
        private ApacheService $service;

        public function __construct($data = null, ApacheService $service = null){
            parent::__construct($data);

            if(null === $service){
                $this->service = ApacheService::detectLocal();
            }
            $this->resetDirectories();
        }

        public function resetDirectories(array $collection = []){
            $this->directories = $collection;
        }

        public function addDirectory(ApacheDirectoryStanza $directory){
            array_push($this->directories, $directory);
        }

        public function jsonSerialize(){
            $simple = (object) [
                'serverName' => $this->serverName,
                'documentRoot' => $this->documentRoot,
                'errorLog' => $this->errorLog,
                'accessLog' => $this->accessLog
            ];
            if(!empty($this->directories)){
                $directories = [];
                foreach ($this->directories as $directory) {
                    $directories[] = $directory->jsonSerialize();
                }
                $simple->directories = (object) $directories;
            }
            return $simple;
        }

        protected function getBuffer():string{
            $buffer = <<<CONF
<VirtualHost *:80>
    ServerName {$this->serverName}
    DocumentRoot {$this->documentRoot}

    {DIRECTORIES}

    <FilesMatch ".php$">
        SetHandler "proxy:unix:/var/run/php/php7.4-fpm.sock|fcgi://localhost/"
    </FilesMatch>

    ErrorLog {$this->errorLog}
    CustomLog {$this->accessLog} combined
</VirtualHost>
CONF;
            $docRootStanza = new ApacheDirectoryStanza((object) ['path' => $this->documentRoot]);
            $this->addDirectory($docRootStanza);

            $directories = implode("\n\t", $this->directories);
            $buffer = str_replace('{DIRECTORIES}', $directories, $buffer);
            return $buffer;
        }

        public function save(ResourceManager $resourceManager = null):?string{
            $buffer = $this->getBuffer();
            if($resourceManager && $resourceManager->isFile()){
                $resourceManager->write($buffer);
                return null;
            }
            return $buffer;
        }
    }
}