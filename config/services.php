<?php

/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Router,
	Phalcon\Mvc\Url as UrlResolver,
	Phalcon\DI\FactoryDefault,
	Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Registering a router
 */
$di['router'] = function() {

	$router = new Router();
        $router->removeExtraSlashes(true);
        $router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);

	$router->setDefaultModule("frontend");
	$router->setDefaultNamespace("Robinson\Frontend\Controllers");
       
        // add backend
        $router->add('/admin', array
        (
            'module' => "backend",
            'namespace' => 'Robinson\Backend\Controllers\\',
            'controller' => 'index',
            'action' => "index",
        ))->setName('admin-index');
        
       $router->add('/admin/:controller/:action', array(
        'module' => 'backend',
        'namespace' => 'Robinson\Backend\Controllers\\',
        'controller' => 1,
        'action' => 2,
    ))->setName('admin');
       
       $router->add('/admin/:controller/:action/:int', array
       (
            'module' => 'backend',
            'namespace' => 'Robinson\Backend\Controllers\\',
            'controller' => 1,
            'action' => 2,
            'id' => 3,
       ))->setName('admin-update');
        
    return $router;
};

$di->set('debug', function()
{
    return new \Phalcon\Debug();
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function() {
	$url = new UrlResolver();
	$url->setBaseUri('/');
	return $url;
};

/**
 * Start the session the first time some component request the session service
 */
$di['session'] = function() {
	$session = new SessionAdapter();
	$session->start();
	return $session;
};

	