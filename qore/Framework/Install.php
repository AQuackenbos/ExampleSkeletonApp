<?php 

namespace Qore\Framework;

final class Install extends \Qore\Framework\Utility\Installer
{
	protected static $_name			=	'Qore_Framework';
	protected static $_version		=	1;
	protected static $_active		=	true;
	
	protected static $_install		=	[
		1	=>	[
			'filesystem'	=>	[],
			'database'		=>	[
				'create'	=>	[
					'modules'	=>	[
						'columns' =>	[
							'name'	=> [
								'type'	=>	'varchar',
								'size'	=>	'100',
								'null'	=>	false
							],
							'installed_version'	=>	[
								'type'	=>	'int',
								'size'	=>	'5',
								'null'	=>	false
							]
						],
						'keys'	=>	[
							'primary'	=>	[
								'name'
							]
						]
					]
				]
			]
		]
	];
}