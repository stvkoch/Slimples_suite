<?php
/**
 * Lib\Controller
 *
 * @category Controller
 * @package Lib
 * @author Team Lib <team-dev@intranet>
 * @license MIT license
 */
namespace Lib;
/**
 * @link Lib\Controller
 */
class Controller
{
	protected $app;

	public function app($name='default')
	{
		return \Slim\Slim::getInstance($name);
	}
}