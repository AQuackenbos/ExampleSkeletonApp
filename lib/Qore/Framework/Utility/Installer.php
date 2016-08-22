<?php

namespace Qore\Framework\Utility;

class Installer extends \Qore\Framework\Utility\UtilityAbstract
{
	protected static $_name;
	protected static $_version;
	protected static $_active;
	protected static $_install;
	
	protected final $__insert = 'INSERT INTO :table (`name`,`installed_version`) VALUES (:name, :version) ON DUPLICATE KEY UPDATE `installed_version` = :version2';
	
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
						$tableName = Qore::tablename($table);
						$statement = Qore::connection()->prepare($query);
						$statement->bindParam(':table',$tableName);
						$statement->execute();
					}
				}
			}
		}
		
		$updateVersion = Qore::connection()->prepare(self::$__insert);
		$updateVersion->bindParam(':table',Qore::tablename('modules'));
		$updateVersion->bindParam(':name',static::$_name);
		$updateVersion->bindParam(':version',static::$_version);
		$updateVersion->bindParam(':version2',static::$_version);
		$updateVersion->execute();
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