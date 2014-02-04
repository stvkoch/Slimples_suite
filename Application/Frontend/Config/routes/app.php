<?php

//why \Lib\Invoker? when Slim append your route, he use is_callable to verify callback and that include/open controller file on stack.

$app->get('/', new \Lib\Invoker('\Application\Frontend\Controller\Home->indexAction'))->name('home.index');
$app->get('/about', new \Lib\Invoker('\Application\Frontend\Controller\Home->aboutAction'))->name('home.about');

//allow chains, but prefere middleware instead this
$app->get('/products/:id', new \Lib\Invoker('\Application\Frontend\Controller\Home->before->productShowAction'))->name('products.show');


