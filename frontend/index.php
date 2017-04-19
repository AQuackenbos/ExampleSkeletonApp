<?php

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

define('FS_ROOT',realpath(__DIR__ . DS . '..'));

$defaultConfig = FS_ROOT . DS .'config.defaults.php';
$configPath = FS_ROOT . DS . 'config.php';

ini_set('display_errors', 1);

if(!file_exists($configPath))
{
	throw new \Qore\Framework\Exception\Fatal('Missing the Qore configuration file.');
	exit;
}

require_once '../vendor/autoload.php';
require_once '../Qore.php';
require_once $defaultConfig;
require_once $configPath;

Qore::setConfig(array_merge($_DEFAULTS,$_CONFIG));
Qore::setModules(array_merge($_QOREMODULES,$_MODULES));

Qore::run();