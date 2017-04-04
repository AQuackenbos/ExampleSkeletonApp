<?php

namespace Qore\Framework\Utility;

class Installer extends \Qore\Framework\Utility\UtilityAbstract
{
	protected static $_name;
	protected static $_version;
	protected static $_active;
	protected static $_install;
	
	/**
	 * Installs the module as defined
	 */
	public static function install()
	{		
		if(!static::$_active)
		{
			throw new Exception('Module disabled!');
		}
	
		if(!static::$_name || !static::$_version)
		{
			throw new Exception('A name and version must be set for a module to install properly.');
		}
		
		if(!is_int(static::$_version))
		{
			throw new Exception('Versions must be integers.');
		}
		
		//Check installed version
		$installed = static::version();
		
		if(is_array(static::$_install))
		{
			foreach(static::$_install as $version => $install)
			{
				if($version < $installed)
				{
					continue;
				}
				
				if(array_key_exists('filesystem',$install) && is_array($install['filesystem']))
				{
					foreach($install['filesystem'] as $command => $data)
					{
						switch($command)
						{
							case 'mkdir':
							case 'rmdir':
							case 'touch':
							case 'rm':
							default:
								throw new Exception('Unsupported filesystem command requested: '.$command);
						}
					}
				}
				
				if(array_key_exists('database',$install) && is_array($install['database']))
				{
					foreach($install['database'] as $table => $query)
					{
						$statement = Qore::connection()->query($query,
							array('table' => Qore::config('database','prefix').$table)
						);
					}
				}
			}
		}
		
		Qore::connection()->table('modules')
			->onDuplicateKeyUpdate->(array('version' => static::$_version))
			->insert(array('name' => static::$_name, 'version' => static::$_version));
	}
	
	/**
	 * Gets the installed version of the module
	 */
	public static function version()
	{
		$iv = Qore::moduleVersion(static::$_name);
		if($iv === false)
		{
			$iv = 0;
		}
		return $iv;
	}
}