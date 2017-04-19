<?php 

$_DEFAULTS = array(
	'modules'	=> array(
		//Disable Modules configured as "Dev Mode"
		'disable_dev'	=>	false,
		//Disable any non-Qore Modules
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
		'options'		=> array(
			PDO::ATTR_DEFAULT_FETCH_MODE =>	PDO::FETCH_ASSOC
		)
	)
);

$_QOREMODULES = array(
	'Qore_Framework'	=>	Qore::MODULE_STATUS_ENABLED
);