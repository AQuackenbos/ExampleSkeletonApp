<?php

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

define('FS_ROOT',realpath(__DIR__ . '/..'));

$configPath = '../config.php';
$defaultConfig = '../config.defaults.php';

ini_set('display_errors', 1);

if(!file_exists($configPath))
{
	//@todo
	echo 'Qore is missing a required configuration file.';
	exit;
}

require_once '../vendor/autoload.php';
require_once '../lib/autoload.php';
require_once $defaultConfig;
require_once $configPath;

Qore::setConfig(array_merge($_DEFAULTS,$_CONFIG));
Qore::setModules(array_merge($_QOREMODULES,$_MODULES));

Qore::run();