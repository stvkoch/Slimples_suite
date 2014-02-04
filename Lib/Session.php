<?php
/**
 * Lib\Session
 *
 * @category Session
 * @package Lib
 * @author Team Lib <team-dev@intranet>
 * @license MIT license
 */
namespace Lib;
/**
 * @link Lib\Session
 */
class Session
{
	/**
	 * maybe you like, same specific configuration or create you own session handler
	 */
	function __construct( $app )
	{
		if(\Lib\Config::get('session-cookie')) {
			$app->add(new \Slim\Middleware\SessionCookie(\Lib\Config::get('session-cookie')));
		} else {
			session_cache_limiter(false);
			session_start();
		}
	}

	static public function get($name)
	{
		return $_SESSION[$name];
	}

	static public function set($name, $value)
	{
		return $_SESSION[$name] = $value;
	}

	static public function delete($name)
	{
		unset($_SESSION[$name]);
	}

}