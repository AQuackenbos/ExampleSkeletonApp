<?php

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

define('ROOT', realpath(__DIR__ . DS . '..'));

require_once '../vendor/autoload.php';
class_alias('\Qore\App','Qore');

ini_set('display_errors', 1);

$configPath = ROOT . DS . 'config.json';

if(!file_exists($configPath))
{
	throw new Qore\Framework\Exception\Fatal('Missing the Qore configuration file.');
	exit;
}

Qore::setConfig($configPath);

Qore::run();