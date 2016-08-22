<?php 

$addlIncludePaths = array(
	'lib'.DS,
	'vendor'.DS
);

set_include_path(get_include_path() . PS . implode(PS,$addlIncludePaths));

spl_autoload_register(function($className){
	$className = ltrim($className,'\\');
	$fileName = '';
	$namespace = '';
	
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DS, $namespace) . DS;
    }
    $fileName .= str_replace('_', DS, $className) . '.php';

    require $fileName;
});