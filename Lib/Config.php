<?php
/**
 * Lib\Config
 *
 * @category Config
 * @package Lib
 * @author Team Lib <team-dev@intranet>
 * @license MIT license
 */
namespace Lib;
/**
 * @link Lib\Config
 */
class Config
{
	protected $path;
	protected $app;
	protected $settings = array();
	static protected $instance = null;

	function __construct($path, $app, $file=null)
	{
		static::$instance = $this;
		$this->path=$path;
		$this->app=$app;
		!is_null($file) && $this->getArray($file);
	}


	static public function instance()
	{
		if(is_null(static::$instance)) throw new \Exception("Instance config is null, need create one");

		return static::$instance;
	}


	public function getArray($file)
	{
		$app = $this->app;
		$folder = static::instance()->path.'/'.static::instance()->app->getMode();
		// static::instance()->settings = array();
		if(file_exists($folder.'/'.$file))
			static::instance()->settings += require( $folder.'/'.$file );
		if(file_exists(static::instance()->path.'/'.$file))
			static::instance()->settings += require( static::instance()->path.'/'.$file ) ;
		return static::instance()->settings;
	}


	static public function get($name, $file=null)
	{
		if(!is_null($file)) static::instance()->getArray($file);
		return static::instance()->settings[$name];
	}


	static public function set($name, $value)
	{
		static::instance()->settings[$name] = $value;
		return static::instance();
	}
}