<?php

class PermissionSystemWrapper extends BaseWrapper
{
    protected $data;
    protected $content;
    protected $resource;
    protected $role;
    protected $action;
    
    public function setData($data = null)
    {
        if ($data == null || !is_object($data)) {
            throw new Exception("Invalid data..");
        }
        
        $this->data = $data;
    }
    
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
    }
	
    public function setRole(Role $role)
    {
        $this->role = $role;
    }
	
    public function setAction(Action $action)
    {
        $this->action = $action;
    }
    
    public function saveResource()
    {
        if (empty($this->data->resource->name)) {
            $this->setMessage('No ha enviado un nombre para el recurso, por favor valide la información');
            throw new InvalidArgumentException('Resource name is empty');
        }
        
        $resource = new Resource();
        $resource->name = $this->data->resource->name;
        $resource->created = time();
        
        if (!$resource->save()) {
            foreach ($resource->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $resource->idResource;
        $object['name'] = $resource->name;
        
        $this->content = array('resources' => $object);
    }
    
	public function saveRole()
	{
		if (empty($this->data->role->name)) {
            $this->setMessage('No ha enviado un nombre para el role, por favor valide la información');
            throw new InvalidArgumentException('Role name is empty');
        }
        
        $role = new Role();
        $role->name = $this->data->role->name;
        $role->created = time();
        
        if (!$role->save()) {
            foreach ($role->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $role->idRole;
        $object['name'] = $role->name;
        
        $this->content = array('role' => $object);
	}
	
	public function saveAction()
	{
		if (empty($this->data->action->name)) {
            $this->setMessage('No ha enviado un nombre para la acción, por favor valide la información');
            throw new InvalidArgumentException('Action name is empty');
        }
        
        $action = new Action();
        $action->name = $this->data->action->name;
        $action->idResource = $this->data->action->resource;
        $action->created = time();
        
        if (!$action->save()) {
            foreach ($action->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $action->idAction;
        $object['name'] = $action->name;
        $object['resource'] = $action->idResource;
        
        $this->content = array('action' => $object);
	}
	
    public function findResources()
    {
        $resources = Resource::find();
        
        $objects = array();
		$actions = array();
		
        if (count($resources) > 0) {
            foreach ($resources as $resource) {
				$idActions = array();
				$actionobjs = Action::findByIdResource($resource->idResource);
				
				if (count($actionobjs) > 0) {
					foreach ($actionobjs as $action) {
						$actions[] = array(
							'id' => $action->idAction,
							'resource' => $action->idResource,
							'name' => $action->name,
						);
						
						$idActions[] = $action->idAction;
					}
				}
				
                $objects[] = array(
                    'id' => $resource->idResource,
                    'name' => $resource->name,
					'actions' => $idActions
                );
            }
        }
        
        $this->content = array('resources' => $objects, 'actions' => $actions);
    }
	
    public function findRelationships()
    {
        $mresources = Resource::find();
        
        $resources = array();
		$actions = array();
		$relationships = array();
		
        if (count($mresources) > 0) {
            foreach ($mresources as $resource) {
				//1. Buscamos las acciones del recurso
				$idActions = array();
				$mactions = Action::findByIdResource($resource->idResource);
				
				if (count($mactions) > 0) {
					foreach ($mactions as $action) {
						//2. Buscamos las relaciones de la accion
						$idRelationships = array();
						$mrelationships = Allowed::find(array(
							'conditions' => 'idAction = ?1',
							'bind' => array(1 => $action->idAction)
						));
						
						if (count($mrelationships) > 0) {
							foreach ($mrelationships as $relationship) {
								$idRelationships[] = $relationship->idAllowed;
								$relationships[] = array(
									'id' => $relationship->idAllowed,
									'role' => $relationship->idRole,
									'action' => $relationship->idAction
								);
							}
						}
						
						$actions[] = array(
							'id' => $action->idAction,
							'resource' => $action->idResource,
							'name' => $action->name,
							'relationships' => $idRelationships
						);
						
						$idActions[] = $action->idAction;
					}
				}
				
                $resources[] = array(
                    'id' => $resource->idResource,
                    'name' => $resource->name,
					'actions' => $idActions
                );
            }
        }
        
		$mroles = Role::find();
		$roles = array();
		
		if (count($mroles) > 0) {
			foreach ($mroles as $role) {
				$idRelationships = array();
				$mrelationships = Allowed::find(array(
					'conditions' => 'idRole = ?1',
					'bind' => array(1 => $role->idRole)
				));

				if (count($mrelationships) > 0) {
					foreach ($mrelationships as $relationship) {
						$idRelationships[] = $relationship->idAllowed;
					}
				}

				$roles[] = array(
					'id' => $role->idRole,
					'name' => $role->name,
					'relationships' => $idRelationships
				);
			}
		}
		
        $this->content = array('resources' => $resources, 'actions' => $actions, 'relationships' => $relationships, 'roles' => $roles);
    }
    
	public function findRoles()
	{
		$resources = Role::find();
        
        $objects = array();
        if (count($resources) > 0) {
            foreach ($resources as $resource) {
                $objects[] = array(
                    'id' => $resource->idRole,
                    'name' => $resource->name,
                );
            }
        }
        
        $this->content = array('roles' => $objects);
	}
	
	public function findAction()
	{
		$actions = Action::find();
        
        $objects = array();
        if (count($actions) > 0) {
            foreach ($actions as $action) {
                $objects[] = array(
                    'id' => $action->idAction,
                    'resource' => $action->idResource,
                    'name' => $action->name,
                );
            }
        }
        
        $this->content = array('actions' => $objects);
	}


	public function editResource()
    {
        if (empty($this->data->resource->name)) {
            $this->setMessage('No ha enviado un nombre para el recurso, por favor valide la información');
            throw new InvalidArgumentException('Resource name is empty');
        }
        
        $this->resource->name = $this->data->resource->name;
        
        if (!$this->resource->save()) {
            foreach ($this->resource->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $this->resource->idResource;
        $object['name'] = $this->resource->name;
        
        $this->content = array('resources' => $object);
    }
	
	public function editRole()
    {
        if (empty($this->data->role->name)) {
            $this->setMessage('No ha enviado un nombre para el role, por favor valide la información');
            throw new InvalidArgumentException('Role name is empty');
        }
        
        $this->role->name = $this->data->role->name;
        
        if (!$this->role->save()) {
            foreach ($this->role->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $this->role->idRole;
        $object['name'] = $this->role->name;
        
        $this->content = array('roles' => $object);
    }
	
	public function editAction()
    {
        if (empty($this->data->action->name)) {
            $this->setMessage('No ha enviado un nombre para la acción, por favor valide la información');
            throw new InvalidArgumentException('Action name is empty');
        }
        
        $this->action->name = $this->data->action->name;
        
        if (!$this->action->save()) {
            foreach ($this->action->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $this->action->idAction;
        $object['name'] = $this->action->name;
        $object['resource'] = $this->action->idResource;
        
        $this->content = array('actions' => $object);
    }
    
    public function deleteResource()
    {
        if (!$this->resource->delete()) {
            foreach ($this->resource->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $this->resource->idResource;
        $object['name'] = $this->resource->name;
        
        $this->content = array('resources' => $object);
    }
	
    public function deleteRole()
    {
        if (!$this->role->delete()) {
            foreach ($this->role->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $this->role->idRole;
        $object['name'] = $this->role->name;
        
        $this->content = array('role' => $object);
    }
	
    public function deleteAction()
    {
        if (!$this->action->delete()) {
            foreach ($this->action->getMessages() as $msg) {
                $this->setMessage($msg);
                throw new InvalidArgumentException($msg);
            }
        }
        
        $object = array();
        $object['id'] = $this->action->idAction;
        $object['name'] = $this->action->name;
        $object['resource'] = $this->action->idResource;
        
        $this->content = array('action' => $object);
    }

    public function getData()
    {
        return $this->content;
    }
}

