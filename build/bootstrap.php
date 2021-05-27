<?php
/**
 * stub.php.
 *
 * TODO: Documentation required!
 */

use Svhq\WsTools\WsToolsCliApplication;

$arguments = array_values($argv);

$path = array_shift($arguments);
$pharPath = dirname(realpath($path));

$projectPath = dirname($pharPath);
$vendorPos = strpos($projectPath, 'vendor/');
if(false !== $vendorPos){
    $projectPath = rtrim(substr($projectPath, 0, $vendorPos), '/');
}
$vendorPath = "{$projectPath}/vendor";
include "{$vendorPath}/autoload.php";

$fallbackConfig = realpath("{$pharPath}/../config/config.json");
$localConfig = "{$projectPath}/config/wstools.json";
$configPath = null;
if(is_readable($fallbackConfig) && is_file($fallbackConfig)){
    $configPath = $fallbackConfig;
}
if(is_readable($localConfig) && is_file($localConfig)){
    $configPath = $localConfig;
}

if(is_null($configPath)){
    echo "Invalid config path\n";
    echo "(fallback: {$fallbackConfig})\n";
    echo "(local: {$localConfig})\n";
    return 0;
}
$exitCode = WsToolsCliApplication::run($configPath);
exit($exitCode);