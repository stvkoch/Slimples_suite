<?php
/**
 * Middleware\Authentication
 * $app->get('/restrictArea', new \Lib\Invoker('\Middleware\Authenticateion->call'), ... );
 * @category Authentication
 * @package Middleware
 * @author Team Middleware <team-dev@intranet>
 * @license MIT license
 */
namespace Middleware;
/**
 * @link Middleware\Authentication
 */
class Authentication extends \Slim\Middleware
{

	/**
	 * use middleware
	 */
	public function call()
	{
		if(\Service\Authentication::logged()) {
			//verify authenticate
			return $this->next->call();
		} else {
			$this->app->redirect($this->app->urlFor('home.login'));
		}
	}

}