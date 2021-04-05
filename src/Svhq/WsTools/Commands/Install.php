<?php


namespace Svhq\WsTools\Commands {

    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\Cli\ExitCodes;
    use Svhq\WsTools\Web\Site;
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
            $site = new Site((object) ['domain' => $this->domain, 'installPath' => $this->installPath, 'publicPath' => "{$this->installPath}/public"]);
            $serializer = new SiteSerializer($site);
            $serializer->create();
            return ExitCodes::GENERIC_ERROR;
        }
    }
}