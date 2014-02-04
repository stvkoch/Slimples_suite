<?php

//this run on index.php context

$view = $app->view(new \Slim\Views\Twig());

$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

$view->parserOptions = array(
    'cache'=>\Lib\Config::get('template-cache')
);

