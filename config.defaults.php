<?php 

$_DEFAULTS = [
	'modules'	=>	[
		//Disable Modules configured as "Dev Mode"
		'disable_dev'	=>	false,
		//Disable any non-Qore Modules
		'disable_all'	=>	false
	],
	'frontend'	=>	[
		//Protocol: [ http | https ]
		'protocol'		=>	'http',
		//Base URL of Website, with trailing slash
		'base_url'		=>	'example.com/',
		//Theme package
		'theme'			=>	'default'
	],
	'admin'		=>	[
		//Protocol: [ http | https ]
		'protocol'		=>	'https',
		//Route name, for the URL; invalid characters may make admin not function
		'route'			=>	'admin',
		//Theme package
		'theme'			=>	'default'
	],
	'database'	=>	[
		//DB Host
		'host'			=>	'localhost',
		//DB Port
		'port'			=>	3306,
		//DB User
		'username'		=>	'username',
		//DB Pass
		'password'		=>	'password',
		//DB Name
		'database'		=>	'database',
		//DB Table Prefix
		'prefix'		=>	'',
		//DB Engine: [ mysql | pgsql | sqlite]
		'driver'		=> 'mysql',
		//DB Engine Options
		'options'		=> [
			PDO::ATTR_DEFAULT_FETCH_MODE =>	PDO::FETCH_ASSOC
		]
	]
];

$_QOREMODULES =	[
	'Qore_Framework'	=>	Qore::MODULE_STATUS_ENABLED
];