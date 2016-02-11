<?php

try {
    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../../app/controllers/',
        '../../app/models/',
        '../../app/forms/',
        '../../app/views/',
        '../../app/plugins/',
        '../../app/wrappers/',
    ));
    
    
    $loader->registerNamespaces(array(
        'Silar\Misc' => '../../app/misc/'
    ), true);
    
    $loader->register();
    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();
               
    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/silar/');
        return $url;
    });
    
    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });
    
    $di->set('router', function () {
        $router = new \Phalcon\Mvc\Router\Annotations();
        $router->addResource('Api', '/api');
        return $router;
    });
    
	// Ruta de APP
    $apppath = realpath('../../../');
    $di->set('appPath', function () use ($apppath) {
        $obj = new \stdClass;
        $obj->path = $apppath;

        return $obj;
    });
	
	$config = new Phalcon\Config\Adapter\Ini('../../../app/config/configuration.ini');
	
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->dbname
        ));
    });
    
    $di->setShared('db', function() use ($di, $config) {
        // Events Manager para la base de datos
        $eventsManager = new \Phalcon\Events\Manager();
        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config->database->toArray());
        $connection->setEventsManager($eventsManager);
        
        return $connection;
    });
              
    $di->set('modelsManager', function(){
        return new \Phalcon\Mvc\Model\Manager();
    });
    
    
    $di->set('logger', function () {
        // Archivo de log
        return new \Phalcon\Logger\Adapter\File("../../app/logs/background.log");
    });
                
	/*
    * Información del sistema
    */
    $path = new \stdClass();
    $path->path = $config->general->path;
    $path->tmpfolder = $config->general->tmp;
    $di->set('path', $path);
	
    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();
} 
catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}