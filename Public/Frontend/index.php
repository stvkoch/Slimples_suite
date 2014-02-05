<?php

define('__ROOT__', __DIR__.'/../..');
define('__APPLICATION__', __ROOT__.'/Application/'.basename(__DIR__));

$loader = require __ROOT__ . '/vendor/autoload.php';
$loader->add('Application\\', __ROOT__);
$loader->add('Conductor\\', __ROOT__);
$loader->add('Lib\\', __ROOT__);
$loader->add('Middleware\\', __ROOT__);
$loader->add('Model\\', __ROOT__);
$loader->add('Presenter\\', __ROOT__);
$loader->add('Service\\', __ROOT__);


Dotenv::load(__ROOT__);

//Slim initialization
$app = new \Slim\Slim( array(
	'mode' => $_ENV['environment'],
	'debug' => (isset($_ENV['environment']) && $_ENV['environment']=='development')
));

//initialize config object
$config = new \Lib\Config(__APPLICATION__.'/Config', $app, 'application.php' );

//maybe you like initialize your own services
include __APPLICATION__.'/Config/bootstrap.php';

//view layer
$app->view()->setTemplatesDirectory(\Lib\Config::get('template-path'));

//route your application
$router = new \Lib\Router(__APPLICATION__.'/Config/routes', $app);
$router->configApp('app.php');
$router->routesApp('routes.php');

//that is ok...
$app->run();
