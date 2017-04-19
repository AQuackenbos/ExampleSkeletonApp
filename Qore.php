<?php 

final class Qore 
{
	/** Data **/
	private static $__version		= '0.1-development';
	private static $__config		= array();
	private static $__modules		= array();
	private static $__connection	= null;
	
	/** Constants **/
	const MODULE_STATUS_DISABLED	=	0;
	const MODULE_STATUS_ENABLED		=	1;
	const MODULE_STATUS_DEV			=	2;
	
	/** Logging Constants **/
	const EOL						= "\n";
	const LOG_PATH					= 'logs'
	const LOG_EXTENSION				= '.log';
	
	
	public static function version()
	{
		return self::__version;
	}
	
	public static function log($message, $file)
	{
		file_put_contents($message . self::EOL, FS_ROOT . DS . self::LOG_PATH . DS . $file . self::LOG_EXTENSION, FILE_APPEND);
	}
	
	public static function connection()
	{
		if(!(self::$__connection instanceof PDO))
		{
			try
			{
				$config = self::config('database');
				self::$__connection = new \Pixie\Connection($config['driver'],$config);
			} 
			catch (Exception $e)
			{
				throw new \Qore\Framework\Exception\Database('Could not connect to configured database.');
				exit;
			}
		}
		return self::$__connection;
	}
	
	public static function session($key, $value = null)
	{
		if($value !== null)
		{
			$_SESSION[$key] = $value;
		}
		
		return $_SESSION[$key];
	}
	
	public static function run()
	{
		session_start();
		
		self::loadModules();
		
		self::serveRoute();
	}
	
	public static function addRoute($route, $controller, $action = false, $params = array())
	{
		
	}
	
	public static function serveRoute($route = false)
	{
		
	}
	
	public static function install($module)
	{
		$class = str_replace('_','\\',$module).'\Install';
		
		try 
		{
			return $class::install();
		} 
		catch (Exception $e)
		{
			echo 'Error installing module: '.$module."\n";
			return false;
		}
	}
	
	public static function loadModules()
	{
		$moduleConfig = self::config('modules');
		foreach(self::$__modules as $module => $status)
		{
			if($status == self::MODULE_STATUS_DISABLED)
			{
				continue;
			}
			
			if($moduleConfig['disable_dev'] && $status == self::MODULE_STATUS_DEV)
			{
				continue;
			}
			if($moduleConfig['disable_all'] && stripos($module,'Qore_Framework') !== 0)
			{
				continue;
			}
			
			self::install($module);
		}
	}
	
	public static function setConfig($configArray)
	{
		self::$__config = $configArray;
	}
	
	public static function setModules($modulesArray)
	{
		self::$__modules = $modulesArray;
	}
	
	public static function config($section,$key = false)
	{
		if($key)
		{
			return self::$__config[$section][$key];
		}
		return self::$__config[$section];
	}
	
	public static function moduleVersion($module)
	{
		try 
		{
			$statement = self::connection()->prepare('SELECT `installed_version` FROM '.self::tablename('modules').' WHERE `name` = :name');
			$statement->bindParam(':name',$module);
			$statement->execute();
			return $statement->fetchColumn();
		} 
		catch (\Qore\Framework\Exception\Database $e)
		{
			return 0;
		}
		catch (\Exception $e)
		{
			return 0;
		}
	}
}