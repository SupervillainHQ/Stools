<?php


namespace Svhq\WsTools\Web\Server\Apache;


use Svhq\Core\Resource\ResourceManager;
use Svhq\WsTools\Web\WebConfig;

class ApacheService{

    private static string $defaultConfigDir = '/etc/apache2/sites-enabled';
    private $configDir;

    public static function defaultConfigDirectory():string{
        return self::$defaultConfigDir;
    }

    public static function detectLocal():?ApacheService{
        // check dir '/etc/apache2/sites-enabled/'
        $configDir = self::$defaultConfigDir;
        $resMan = ResourceManager::resourceManager($configDir);
        if($resMan->isDirectory()){
            $local = new ApacheService();
            $local->setConfigDir($resMan);
            return $local;
        }
        return null;
    }

    public function setConfigDir($path){
        $this->configDir = $path;
    }

    public function configDir():string{
        return $this->configDir;
    }

    public function listConfigs(){}

    public function unlinkConfig(WebConfig $configFile){}

    public function linkConfig(WebConfig $configFile, string $link){}

    public function addConfig(WebConfig $config){}
}