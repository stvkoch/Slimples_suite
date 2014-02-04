<?php
/**
 * Application\Frontend\Controller\Home
 *
 * $app = Slim::getInstance()
 *
 * indexAction
 * aboutAction
 * productShowAction
 *
 * @category Home
 * @package Application\Frontend\Controller
 * @author Team Application\Frontend\Controller <team-dev@intranet>
 * @license MIT license
 */
namespace Application\Frontend\Controller;

/**
 * @link Application\Frontend\Controller\Home
 */
class Home extends \Lib\Controller
{

	public function indexAction()
	{
		echo $this->app()->render('Home\index.html');

		return $this;
	}

	public function before()
	{
		//this is only for yor home controller, consider using middleware for your applications logic

		return $this; //always return $this
	}


	public function aboutAction(){
		echo $this->app()->render('Home\about.html');
	}

	public function productShowAction( $id ){
		echo $this->app()->render('Home\products.html');
	}

}