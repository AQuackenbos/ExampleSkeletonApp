<?php 

namespace Qore\Framework;

final class Install extends \Qore\Framework\Utility\Installer
{
	protected static $_name			=	'Qore_Framework';
	protected static $_version		=	1;
	protected static $_active		=	true;
	
	protected static $_install		=	array(
		1	=>	array(
			'filesystem'	=>	array(),
			'database'		=>	array(
				'modules'	=>
					'CREATE TABLE IF NOT EXISTS :table (
						`name` VARCHAR(100) NOT NULL,
						`installed_version` INT(5) NOT NULL,
						PRIMARY KEY (`name`)
					)'
			)
		)
	);
}