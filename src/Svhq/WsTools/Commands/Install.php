<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\Console;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\Core\Resource\ResourceManager;
    use Svhq\WsTools\Commands\Config\Create as ConfigCreate;
    use Svhq\WsTools\Web\Repo\GitRepository;
    use Svhq\WsTools\Web\Repo\GitRepositorySerializer;
    use Svhq\WsTools\Web\SiteSerializer;

    class Install implements CliCommand {

        /**
         * @var int
         */
        private int $verbosity;
        private string $domain;
        private string $installPath;
        private ?string $repository;

        /**
         * Install constructor.
         * @param string $domain
         * @param string|null $installPath
         * @param string|null $repository
         * @param int $verbosity
         */
        public function __construct(string $domain, string $installPath = null, string $repository = null, int $verbosity = 0){
            $this->domain = $domain;
            $this->installPath = $installPath ?: "/var/www/{$domain}";
            $this->repository = $repository ?: "git@github.com/{$domain}.git";
            $this->verbosity = $verbosity;
        }

        function execute(): ?int{
            $repositoryData = (object) [
                'url' => $this->repository,
                'type' => GitRepository::TYPE_GIT
            ];
            $repository = GitRepositorySerializer::insert($repositoryData);

            $siteData = (object) [
                'domain' => $this->domain,
                'installPath' => $this->installPath,
                'publicPath' => "{$this->installPath}/public",
                'repository' => $repository
            ];
            $site = SiteSerializer::insert($siteData);

            $serverConfFilePath = "{$this->installPath}/apache.conf";
            $resMan = ResourceManager::resourceManager($serverConfFilePath);
            if(!$resMan->isFile()){
                $confCreate = new ConfigCreate($this->domain, $serverConfFilePath);
                $confCreate->setResourceManager($resMan);
                $confCreate->execute();
            }

            Console::log("site {$site->domain()} installed at '{$site->installpath()}'");
            return ExitCodes::GENERIC_ERROR;
        }
    }
}