<?php 

$_DEFAULTS = array(
	'modules'	=> array(
		//Disable Modules configured as "Dev Mode"
		'disable_dev'	=>	false,
		//Disable any non-Qore Module
		'disable_all'	=>	false
	),
	'frontend'	=> array(
		//Protocol: [ http | https ]
		'protocol'		=>	'http',
		//Base URL of Website, with trailing slash
		'base_url'		=>	'example.com/',
		//Theme package
		'theme'			=>	'default'
	),
	'database'	=> array(
		//DB Host
		'hostname'		=>	'localhost',
		//DB Port
		'port'			=>	3306,
		//DB User
		'username'		=>	'username',
		//DB Pass
		'password'		=>	'password',
		//DB Name
		'database'		=>	'database',
		//DB Table Prefix
		'table_prefix'	=>	'',
		//DB Engine: [ mysql ]
		'engine'		=> 'mysql'
	)
);

$_QOREMODULES = array(
	'Qore_Framework'	=>	Qore::MODULE_STATUS_ENABLED
);