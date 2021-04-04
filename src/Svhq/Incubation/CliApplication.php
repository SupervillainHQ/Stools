<?php


namespace Svhq\Incubation {

    use Svhq\Core\Annotations\Cli\CliAnnotationsProcessor;
    use Svhq\Core\Cli\Console;
    use Svhq\Core\Config\Config;
    use Phalcon\Di\FactoryDefault\Cli;
    use Svhq\Core\Cli\CliCommand;
    use Svhq\Core\System\DependencyLoader;
    use Svhq\Core\Cli\ExitCodes;

    abstract class CliApplication{
        private static CliApplication $instance;
        /**
         * @var Cli
         */
        private Cli $di;
        private Config $config;

        public static function instance():CliApplication{
            if(!isset(self::$instance)){
                self::$instance = new static();
            }
            return self::$instance;
        }

        private function __construct(){
            $this->di = new Cli();
        }

        /**
         * @param string $path
         */
        public function setConfigPath(string $path): void{
            if($config = Config::loadFromPath($path)){
                $this->config = $config;
            }
        }

        public static function run(string $configPath){
            $instance = self::instance();
            $instance->setConfigPath($configPath);
            DependencyLoader::loadFromConfig($instance->di, null, true);

            if($command = $instance->initCommand()){
                return $command->execute();
            }
            exit(ExitCodes::INVALID_COMMAND);
        }

        abstract protected function initCommand():?CliCommand;
    }
}