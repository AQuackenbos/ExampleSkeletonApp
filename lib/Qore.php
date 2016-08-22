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
	
	public static function version()
	{
		return self::__version;
	}
	
	public static function connection()
	{
		if(!(self::$__connection instanceof PDO))
		{
			try
			{
				$config = self::config('database');
				$dsn = $config['engine'].':host='.$config['hostname'].';port='.$config['port'].';dbname='.$config['database'];
				self::$__connection = new PDO($dsn, $config['username'], $config['password']);
				self::$__connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			} 
			catch (Exception $e)
			{
				echo 'Could not connect to database!';
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
		
		return $_SESSION[$key]
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
			if($moduleConfig['disable_dev'] && $status == self::MODULE_STATUS_DEV)
			{
				continue;
			}
			if($moduleConfig['disable_all'] && stripos($module,'Qore_') !== 0)
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
		$statement = self::connection()->prepare('SELECT `installed_version` FROM '.self::tablename('modules').' WHERE `name` = :name');
		$statement->bindParam(':name',$module);
		$statement->execute();
		return $statement->fetchColumn();
	}
	
	public static function tablename($tablename)
	{
		return self::config('database','table_prefix').$tablename;
	}
}