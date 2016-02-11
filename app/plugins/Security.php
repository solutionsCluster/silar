<?php

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;

/**
 * Security
 *
 * Este es la clase que proporciona los permisos a los usuarios. Esta clase decide si un usuario pueder hacer determinada
 * tarea basandose en el tipo de ROLE que posea
 */
class Security extends Plugin {

    protected $system;
    protected $ip;

    public function __construct($dependencyInjector, $system, $ip = null) {
        $this->_dependencyInjector = $dependencyInjector;
        $this->system = $system;
        $this->ip = $ip;
    }

    public function getAcl() {
        /*
         * Buscar ACL en cache
         */
//		$acl = $this->cache->get('acl-cache');
//		if (!$acl) {
        // No existe, crear objeto ACL

        $acl = new Phalcon\Acl\Adapter\Memory();
        $acl->setDefaultAction(Phalcon\Acl::DENY);
//			$acl = $this->acl;

        $userroles = Role::find();

        $modelManager = Phalcon\DI::getDefault()->get('modelsManager');

        $sql = "SELECT Resource.name AS resource, Action.name AS action 
                                    FROM Action
                                            JOIN Resource ON (Action.idResource = Resource.idResource)";

        $results = $modelManager->executeQuery($sql);

        $userandroles = $modelManager->executeQuery('SELECT Role.name AS rolename, Resource.name AS resname, Action.name AS actname
                                                                                                             FROM Allowed
                                                                                                                JOIN Role ON (Role.idRole = Allowed.idRole) 
                                                                                                                JOIN Action ON (Action.idAction = Allowed.idAction) 
                                                                                                                JOIN Resource ON (Action.idResource = Resource.idResource)');

        //Registrando roles
        foreach ($userroles as $role) {
            $acl->addRole(new Phalcon\Acl\Role($role->name));
        }

        //Registrando recursos
        $resources = array();
        foreach ($results as $key) {
            if (!isset($resources[$key['resource']])) {
                $resources[$key['resource']] = array($key['action']);
            }
            $resources[$key['resource']][] = $key['action'];
        }

        foreach ($resources as $resource => $actions) {
            $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
        }

        //Relacionando roles y recursos desde la base de datos
        foreach ($userandroles as $role) {
            $acl->allow($role->rolename, $role->resname, $role->actname);
        }

//			$this->cache->save('acl-cache', $acl);
//		}
        // Retornar ACL
        $this->_dependencyInjector->set('acl', $acl);
        return $acl;
    }

    protected function getControllerMap() {
//          $map = $this->cache->get('controllermap-cache');
//          if (!$map) {
        $map = array(
            //Public resources and actions
            'session::login' => array(),
            'session::validatesession' => array(),
            'session::logout' => array(),
            'session::recoverpassword' => array(),
            'session::resetpassword' => array(),
            'session::setnewpass' => array(),
            'error::index' => array(),
            'error::notavailable' => array(),
            'error::unauthorized' => array(),
			
			//Inventory
            'inventories::index' => array('report' => array('read')),
            'inventories::showreport' => array('report' => array('read')),
            //Sales
            'sales::index' => array('report' => array('read')),
            'sales::showreport' => array('report' => array('read')),
			//Portfolio
            'portfolio::index' => array('report' => array('read')),
			'portfolio::showreport' => array('report' => array('read')),
			
            //Dashboard
            'index::index' => array('dashboard' => array('read')),
			
            //Managment
            'managment::index' => array('dashboard' => array('read')),
			
            //Reportes
            'report::index' => array('report' => array('read')),
            'report::new' => array('report' => array('create', 'read')),
            'report::edit' => array('report' => array('read', 'update')),
            'report::delete' => array('report' => array('read', 'delete')),
            'report::getdataforreport' => array('report' => array('getdata')),
			'report::createreport' => array('report' => array('download')),
            'report::downloadreport' => array('report' => array('download')),
			
			//filters
            'filter::getyears' => array('report' => array('read')),
            'filter::getdays' => array('report' => array('read')),
            'filter::getmonths' => array('report' => array('read')),
            'filter::getbranches' => array('report' => array('read')),
            'filter::getlines' => array('report' => array('read')),
            'filter::getgroups' => array('report' => array('read')),
            'filter::getbrands' => array('report' => array('read')),
			
            //Accounts
            'account::index' => array('account' => array('read')),
            'account::new' => array('account' => array('create', 'read')),
            'account::addpaymentplan' => array('account' => array('create', 'read', 'update')),
            'account::edit' => array('account' => array('read', 'update')),
            'account::delete' => array('account' => array('read', 'delete')),
            'account::changestatus' => array('account' => array('read', 'update')),
            'account::showusers' => array('account' => array('read', 'update')),
            'account::edituser' => array('account' => array('read', 'update')),
            'account::changeuserstatus' => array('account' => array('read', 'update')),
            'account::changepassword' => array('account' => array('read', 'update')),
            'account::newuser' => array('account' => array('read', 'create')),
            'account::getpaymentsplan' => array('account' => array('read', 'create')),
            'account::setpaymentplan' => array('account' => array('read', 'create', 'update')),
            'account::quitpaymentplan' => array('account' => array('read', 'create', 'update')),
			
            
            //Users
            'user::index' => array('user' => array('read')),
            'user::new' => array('user' => array('read', 'create')),
            'user::edit' => array('user' => array('read', 'update')),
            'user::delete' => array('user' => array('read', 'delete')),
            'user::changepassword' => array('user' => array('read', 'update')),
			
            //Image bank
            'imagebank::index' => array('imagebank' => array('read')),
            'imagebank::newloginimage' => array('imagebank' => array('read', 'upload')),
            'imagebank::deleteloginimage' => array('imagebank' => array('read', 'delete')),
			
            //Payments plan
            'paymentplan::index' => array('paymentplan' => array('read')),
            'paymentplan::new' => array('paymentplan' => array('read', 'create')),
            'paymentplan::edit' => array('paymentplan' => array('read', 'update')),
            'paymentplan::delete' => array('paymentplan' => array('read', 'delete')),
            'paymentplan::getpaymentsplan' => array('paymentplan' => array('read', 'delete')),
			
            //Ciuu code
            'ciuucode::index' => array('ciuucode' => array('read')),
            'ciuucode::new' => array('ciuucode' => array('read', 'create')),
            'ciuucode::edit' => array('ciuucode' => array('read', 'update')),
            'ciuucode::delete' => array('ciuucode' => array('read', 'delete')),
			
            //Permission system
            'permissionsystem::index' => array('permissionsystem' => array('read')),
            'api::indexrole' => array('role' => array('read')),
            'api::newrole' => array('role' => array('create')),
            'api::editrole' => array('role' => array('update')),
            'api::deleterole' => array('role' => array('delete')),
            'api::newaction' => array('action' => array('read')),
            'api::editaction' => array('action' => array('create')),
            'api::deleteaction' => array('action' => array('delete')),
            'api::newresource' => array('resource' => array('create')),
            'api::indexresource' => array('resource' => array('read')),
            'api::editresource' => array('resource' => array('update')),
            'api::deleteresource' => array('resource' => array('delete')),
        );
//          }
//          $this->cache->save('controllermap-cache', $map);
        return $map;
    }

    /**
     * This action is executed before execute any action in the application
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher) {
        $controller = strtolower($dispatcher->getControllerName());
        $action = strtolower($dispatcher->getActionName());
        $resource = "$controller::$action";

//		if ($this->serverStatus == 0 && !in_array($this->ip, $this->system->ipaddresses)) {
        if ($this->system->status == 0) {
            $this->publicurls = array(
                'error::index',
                'error::link',
                'error::notavailable',
                'error::unauthorized',
            );

            $accessdir = "{$controller}::{$action}";

            if (!in_array($accessdir, $this->publicurls)) {
                return $this->response->redirect('error/notavailable');
            }
            return false;
        }

        $role = 'guest';

        if ($this->session->get('authenticated')) {
            $user = User::findFirstByIdUser($this->session->get('user-id'));
            if ($user) {
                $role = $user->role->name;
                // Inyectar el usuario
                $this->_dependencyInjector->set('userObject', $user);

                $userefective = new stdClass();
                $userefective->enable = false;

                $efective = $this->session->get('userefective');
                if (isset($efective)) {
                    $userefective->enable = true;
                }

                $this->_dependencyInjector->set('userefective', $userefective);
            }
        }

        $map = $this->getControllerMap();

        $this->publicurls = array(
            'session::login',
            'session::validatesession',
            'session::logout',
            'session::recoverpassword',
            'session::resetpassword',
            'session::setnewpass',
            'error::index',
            'error::link',
            'error::notavailable',
            'error::unauthorized',
        );

        if ($resource == "error::notavailable") {
            $this->response->redirect('index');
            return false;
        }

        if ($role == 'guest') {
            $accessdir = "{$controller}::{$action}";

            if (!in_array($accessdir, $this->publicurls)) {
                $this->response->redirect("session/login");
                return false;
            }
        } else {
            $acl = $this->getAcl();
            $this->logger->log("Validando el usuario con rol [$role] en [$resource]");


            if (!isset($map[$resource])) {
                $this->logger->log("Redirect to error");
                // Uso forward para que la URL se mantenga, y así el usuario pueda
                // saber cual es la que da problemas
                $dispatcher->forward(array('controller' => 'error', 'action' => 'index'));
                return false;
            }


            $reg = $map[$resource];

            foreach ($reg as $resources => $actions) {
                foreach ($actions as $act) {
                    if (!$acl->isAllowed($role, $resources, $act)) {
                        $this->logger->log("{$controller}::{$action} not allowed");
//						$this->logger->log(print_r($acl, true));
                        // Uso forward para que la URL se mantenga, y así el usuario pueda
                        // saber cual es la que da problemas
                        $dispatcher->forward(array('controller' => 'error', 'action' => 'unauthorized'));
                        return false;
                    }
                }
            }

//			$mapForLoginLikeAnyUser = array('session::loginlikethisuser');
//			
//			if (in_array($resource, $mapForLoginLikeAnyUser)) {
//				$this->session->set('userefective', $user);
//			}

            return true;
        }
    }

}
