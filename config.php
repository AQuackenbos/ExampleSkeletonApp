<?php 

//Parse Heroku DB Config
$dbopts = parse_url(getenv('DATABASE_URL'));

//Custom Configuration
$_CONFIG =	[
	//Custom Configuration Array - Overrides Default Values
	'frontend'	=>	[
		'base_url'	=>	'salty-citadel-82541.herokuapp.com/'
	],
	//Your Database Connection Settings
	'database' =>	[
		'driver'	=>	'pgsql',
		'host'		=>	$dbopts['host'],
		'username'	=>	$dbopts['user'],
		'password'	=>	$dbopts['pass'],
		'database'	=>	ltrim($dbopts["path"],'/'),
		'port'		=>	$dbopts['port']
	]
];

//Modules List 
$_MODULES =	[
	//'Namespace_Module' => Qore::MODULE_STATUS_[ENABLED|DISABLED|DEV]
];
