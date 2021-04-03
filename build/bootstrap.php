<?php
/**
 * stub.php.
 *
 * TODO: Documentation required!
 */

use SupervillainHQ\WsTools\WsToolsCliApplication;
use Commando\Command as NateGoodCommand;

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

$cmd = new NateGoodCommand();

// Can't use imported classes until we've determined where the vendor-dir is, so we need to reserve the first argument for
// something that allows us to locate the vendor-dir
//$cmd->option()
//	->require()
//	->describedAs("path to config.xml");

$cmd->option()
    ->aka('subcommand')
    ->require()
    ->describedAs('Sub-command');

$cmd->option('v')
    ->aka('verbose')
    ->describedAs('When set, extended logging is enabled')
    ->count(3);

//$cmd->option('c')
//    ->aka('command')
//    ->describedAs('Maintenance command name. Case-sensitive!')
//    ->argument();

$verbose = $cmd['verbose'];

if($verbose){
    echo "PATH: {$path}\n";
    echo "EXE PATH: {$pharPath}\n";
    echo "LOCAL PROJECT PATH: {$projectPath}\n";
    echo "LOCAL VENDOR PATH: {$vendorPath}\n";
    echo "CONFIG PATH: {$configPath}\n";
}

if(is_null($configPath)){
    echo "Invalid config path\n";
    echo "(fallback: {$fallbackConfig})\n";
    echo "(local: {$localConfig})\n";
    return 0;
}
WsToolsCliApplication::run($configPath, $cmd);