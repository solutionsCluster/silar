<?php
require_once '../bootstrap/index.php';

$permissions = new PermissionsDataBase();
$permissions->executeSqls();

class PermissionsDataBase
{
	public $roles;
	public $resources;
	public $actions;
	public $allowed;
	
	public function __construct() 
	{
		$this->loadRoles();
		$this->loadResources();
		$this->loadActions();
		$this->loadAllowed();
	}
	
	
	public function loadRoles()
	{
		$this->roles = array(
			'sudo' => 1,
			'admin' => 2
		);
	}
	
	public function loadResources()
	{
		$this->resources = array(
			'user' => 1,
			'account' => 2,
			'imagebank' => 3,
			'paymentplan' => 4,
			'ciuucode' => 5,
			'permissionsystem' => 6,
			'dashboard' => 7,
			'report' => 8,
			'role' => 9,
			'action' => 10,
			'resource' => 11,
		);
	}
	
	public function loadActions()
	{
		$this->actions = array(
			'user::create' => 1,
			'user::read' => 2,
			'user::update' => 3,
			'user::delete' => 4,
			'user::root' => 5,
			
			'account::create' => 6,
			'account::read' => 7,
			'account::update' => 8,
			'account::delete' => 9,
			
			'imagebank::create' => 10,
			'imagebank::read' => 11,
			'imagebank::update' => 12,
			'imagebank::delete' => 13,
			
			'paymentplan::create' => 14,
			'paymentplan::read' => 15,
			'paymentplan::update' => 16,
			'paymentplan::delete' => 17,
			
			'ciuucode::create' => 18,
			'ciuucode::read' => 19,
			'ciuucode::update' => 20,
			'ciuucode::delete' => 21,
			
			'permissionsystem::read' => 22,
			
			'dashboard::read' => 23,
			
			'report::create' => 24,
			'report::read' => 25,
			'report::update' => 26,
			'report::delete' => 27,
			'report::getdata' => 28,
			'report::download' => 29,
			
			'role::create' => 30,
			'role::read' => 31,
			'role::update' => 32,
			'role::delete' => 33,
			
			'action::create' => 34,
			'action::read' => 35,
			'action::update' => 36,
			'action::delete' => 37,
			
			'resource::create' => 38,
			'resource::read' => 39,
			'resource::update' => 40,
			'resource::delete' => 41,
		);
	}
	
	public function loadAllowed()
	{
		$this->allowed = array(
//			----------//----------**ROLE_SUDO**----------//----------
			array( 'Role' => 'sudo', 'Action' => 'user::create'),
			array( 'Role' => 'sudo', 'Action' => 'user::read'),
			array( 'Role' => 'sudo', 'Action' => 'user::update'),
			array( 'Role' => 'sudo', 'Action' => 'user::delete'),
			array( 'Role' => 'sudo', 'Action' => 'user::root'),

			array( 'Role' => 'sudo', 'Action' => 'account::create'),
			array( 'Role' => 'sudo', 'Action' => 'account::read'),
			array( 'Role' => 'sudo', 'Action' => 'account::update'),
			array( 'Role' => 'sudo', 'Action' => 'account::delete'),
			
			array( 'Role' => 'sudo', 'Action' => 'imagebank::create'),
			array( 'Role' => 'sudo', 'Action' => 'imagebank::read'),
			array( 'Role' => 'sudo', 'Action' => 'imagebank::update'),
			array( 'Role' => 'sudo', 'Action' => 'imagebank::delete'),
			
			array( 'Role' => 'sudo', 'Action' => 'paymentplan::create'),
			array( 'Role' => 'sudo', 'Action' => 'paymentplan::read'),
			array( 'Role' => 'sudo', 'Action' => 'paymentplan::update'),
			array( 'Role' => 'sudo', 'Action' => 'paymentplan::delete'),
			
			array( 'Role' => 'sudo', 'Action' => 'ciuucode::create'),
			array( 'Role' => 'sudo', 'Action' => 'ciuucode::read'),
			array( 'Role' => 'sudo', 'Action' => 'ciuucode::update'),
			array( 'Role' => 'sudo', 'Action' => 'ciuucode::delete'),
			
			array( 'Role' => 'sudo', 'Action' => 'permissionsystem::read'),
			
			array( 'Role' => 'sudo', 'Action' => 'dashboard::read'),
			
			array( 'Role' => 'sudo', 'Action' => 'report::create'),
			array( 'Role' => 'sudo', 'Action' => 'report::read'),
			array( 'Role' => 'sudo', 'Action' => 'report::update'),
			array( 'Role' => 'sudo', 'Action' => 'report::delete'),
			array( 'Role' => 'sudo', 'Action' => 'report::getdata'),
			array( 'Role' => 'sudo', 'Action' => 'report::download'),
			
			array( 'Role' => 'sudo', 'Action' => 'role::create'),
			array( 'Role' => 'sudo', 'Action' => 'role::read'),
			array( 'Role' => 'sudo', 'Action' => 'role::update'),
			array( 'Role' => 'sudo', 'Action' => 'role::delete'),
			
			array( 'Role' => 'sudo', 'Action' => 'action::create'),
			array( 'Role' => 'sudo', 'Action' => 'action::read'),
			array( 'Role' => 'sudo', 'Action' => 'action::update'),
			array( 'Role' => 'sudo', 'Action' => 'action::delete'),
			
			array( 'Role' => 'sudo', 'Action' => 'resource::create'),
			array( 'Role' => 'sudo', 'Action' => 'resource::read'),
			array( 'Role' => 'sudo', 'Action' => 'resource::update'),
			array( 'Role' => 'sudo', 'Action' => 'resource::delete'),
			
			
//			----------//----------**ROLE_ADMIN**----------//----------
			array( 'Role' => 'admin', 'Action' => 'user::create'),
			array( 'Role' => 'admin', 'Action' => 'user::read'),
			array( 'Role' => 'admin', 'Action' => 'user::update'),
			array( 'Role' => 'admin', 'Action' => 'user::delete'),
		
			array( 'Role' => 'admin', 'Action' => 'dashboard::read'),
			
			array( 'Role' => 'admin', 'Action' => 'report::create'),
			array( 'Role' => 'admin', 'Action' => 'report::read'),
			array( 'Role' => 'admin', 'Action' => 'report::update'),
			array( 'Role' => 'admin', 'Action' => 'report::delete'),
			array( 'Role' => 'admin', 'Action' => 'report::getdata'),
			array( 'Role' => 'admin', 'Action' => 'report::download'),
		);
		
	}
	
	public function executeSqls()
	{
		$now = time();
		$sqlRoles = "INSERT IGNORE INTO role VALUES ";
		$first = true;
		foreach($this->roles as $name => $id) {
			if(!$first) {
				$sqlRoles.=', ';
			}
			$sqlRoles.= "('{$id}', '{$name}', {$now})";
			$first = false;
		}

		$sqlResource = "INSERT IGNORE INTO resource VALUES ";
		$first = true;
		foreach($this->resources as $name => $id) {
			if(!$first) {
				$sqlResource.=', ';
			}
			$sqlResource.= "('{$id}', '{$name}', {$now})";
			$first = false;
		}
		
		$sqlAction = "INSERT IGNORE INTO action VALUES ";
		$first = true;
		foreach($this->actions as $name => $id) {
			if(!$first) {
				$sqlAction.=', ';
			}
			$data = explode('::', $name); 
			$sqlAction.= "('{$id}', '{$this->resources[$data[0]]}', '{$data[1]}', {$now})";
			$first = false;
		}

		$sqlAllowed = "INSERT IGNORE INTO allowed VALUES ";
		$first = true;
		foreach($this->allowed as $key => $value) {
			if(!$first) {
				$sqlAllowed.=', ';
			}
			$id = $key + 1 ;
			$sqlAllowed.= "('{$id}', '{$this->roles[$value['Role']]}', '{$this->actions[$value['Action']]}', {$now})";
			$first = false;
		}
		
		$db = Phalcon\DI::getDefault()->get('db');
		
		$db->begin();
		
		$db->execute('SET foreign_key_checks = 0');
		
		$db->execute('TRUNCATE TABLE role');
		$db->execute('TRUNCATE TABLE resource');
		$db->execute('TRUNCATE TABLE action');
		$db->execute('TRUNCATE TABLE allowed');
		
		$execRole = $db->execute($sqlRoles);
		$execResource = $db->execute($sqlResource);
		$execAction = $db->execute($sqlAction);
		$execAllowed = $db->execute($sqlAllowed);
		
		$db->execute('SET foreign_key_checks = 1');
		
		if (!$execRole || !$execResource || !$execAction || !$execAllowed) {
			$db->rollback();
		}
		
		$db->commit();	
	}
}
