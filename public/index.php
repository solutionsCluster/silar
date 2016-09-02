<?php

try {
    $config = new Phalcon\Config\Adapter\Ini('../app/config/configuration.ini');
    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/',
        '../app/forms/',
        '../app/views/',
        '../app/plugins/',
        '../app/wrappers/',
    ));
    
    
    $loader->registerNamespaces(array(
        'Silar\Misc' => '../app/misc/'
    ), true);
    
    $loader->register();
    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();
    
   //Registering Volt as template engine
    $di->set('view', function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".volt" => 'Phalcon\Mvc\View\Engine\Volt'
        ));

        return $view;
    });
                
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
    
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->dbname
        ));
    });
    
    $di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });
    
    $di->set('hash', function(){
        $hash = new \Phalcon\Security();
        //Set the password hashing factor to 12 rounds
        $hash->setWorkFactor(12);
        return $hash;
    }, true);
    
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
        return new \Phalcon\Logger\Adapter\File("../app/logs/debug.log");
    });
    
    $urlManager = new \Silar\Misc\UrlManager($config);
	
    $di->set('urlManager', $urlManager);   
                
    $di->set('flashSession', function(){
        $flash = new \Phalcon\Flash\Session(array(
            //'error' => 'alert alert-danger',
            //'success' => 'alert alert-success',
            //'notice' => 'alert alert-info',
            //'warning' => 'alert alert-warning',
            'error' => 'alert alert-danger text-center',
            'success' => 'alert alert-success text-center',
            'notice' => 'alert alert-info text-center',
            'warning' => 'alert alert-warning text-center',
        ));
        
        return $flash;
    });
    
    /*
    * Este objeto se encarga de crear el menú principal sidebar de la izquierda
    */
    $di->set('menu', function(){
        return new \Silar\Misc\SmartMenuSidebar();
    });
	
	/*
    * Información del sistema
    */
    $system = new \stdClass;
    $system->status = $config->system->status;
    $system->ipaddresses = $config->system->ipaddresses;
    $di->set('system', $system);
	
	/*
	 * Información del smtp de soporte
	 */
	$smtpsupport = new \stdClass;
    $smtpsupport->smtp = $config->smtpsupport->smtp;
    $smtpsupport->port1 = $config->smtpsupport->port1;
    $smtpsupport->port2 = $config->smtpsupport->port2;
    $smtpsupport->port3 = $config->smtpsupport->port3;
    $smtpsupport->name = $config->smtpsupport->name;
    $smtpsupport->email = $config->smtpsupport->email;
    $smtpsupport->user = $config->smtpsupport->user;
    $smtpsupport->password = $config->smtpsupport->password;
    $di->set('smtpsupport', $smtpsupport);
	
	/*
    * Conexión a firebird
    */
    $firebird = new \stdClass;
    $firebird->dir = $config->firebird->dir;
    $firebird->host = $config->firebird->host;
    $firebird->username = $config->firebird->username;
    $firebird->password = $config->firebird->password;
    $di->set('firebird', $firebird);
	
    /**
     * Se encarga de monitorear los accesos a los controladores y acciones, y asi mismo pasarle los parametros
     * de seguridad a security 
     */
     $ip = $_SERVER['SERVER_ADDR'];
     $di->set('dispatcher', function() use ($di, $system, $ip) {
     	$eventsManager = $di->getShared('eventsManager');
     	$security = new \Security($di, $system, $ip);
        /**
         * We listen for events in the dispatcher using the Security plugin
         */
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });
	
    /*
    * Este objeto se encarga de cargar la imagen dinámica de la página de inicio de sesión
    */
    $di->set('loginimage', function(){
        return new \Silar\Misc\LoginImageManager();
    });
    
    // Ruta de APP
    $apppath = realpath('../');
    $di->set('appPath', function () use ($apppath) {
        $obj = new \stdClass;
        $obj->path = $apppath;

        return $obj;
    });
    
    $path = new \stdClass();
    $path->path = $config->general->path;
    $path->tmpfolder = $config->general->tmp;
    $di->set('path', $path);
    
    $di->set('hash', function(){
        $hash = new \Phalcon\Security();
        //Set the password hashing factor to 12 rounds
        $hash->setWorkFactor(12);
        return $hash;
    }, true);
                
    /*
    * Este objeto contiene los datos de ubicación del banco de imágenes
    */
    $imgbnk = new \stdClass;
    $imgbnk->loginimages = $config->imagebank->loginimages;
    $imgbnk->appimages = $config->imagebank->appimages;
    $imgbnk->userdir = $config->imagebank->userdir;
    $imgbnk->systemsize = $config->imagebank->systemsize;
    $imgbnk->dirname = $config->imagebank->dirname;
    $imgbnk->relativeloginimages = $config->imagebank->relativeloginimages;
    $imgbnk->relativeappimages = $config->imagebank->relativeappimages;
    $imgbnk->relativeuserdir = $config->imagebank->relativeuserdir;
    $di->set('imgbnk', $imgbnk);
	
    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();
} 
catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}
