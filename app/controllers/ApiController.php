<?php

/**
 * @RoutePrefix("/api")
 */
class ApiController extends ControllerBase
{
    /**
     * 
     * @Get("/resources")
     */
    public function indexresourceAction()
    {
        try {
            $wrapper = new PermissionSystemWrapper();
            $wrapper->findResources();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (Exception $ex) {
            $this->logger->log("Exception while finding resources... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
    
    /**
     * 
     * @Post("/resources")
     */
    public function newresourceAction()
    {
        $contentsraw = $this->getRequestContent();
        $contentsT = json_decode($contentsraw);
//        $this->logger->log('Turned it into this: [' . print_r($contentsT, true) . ']');
        $wrapper = new PermissionSystemWrapper();
        
        try {
            $wrapper->setData($contentsT);
            $wrapper->saveResource();
            $data = $wrapper->getData();
            
            return $this->setJsonResponse($data, 200 , 'Se ha guardado el recurso exitosamente');
        }
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while saving resource... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while saving resource... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, $wrapper->getMessage());
        }
    }
    
    /**
    * 
    * @Put("/resources/{idResource:[0-9]+}")
    */
    public function editresourceAction($idResource)
    {
        $resource = Resource::findFirst(array(
            'conditions' => 'idResource = ?1',
            'bind' => array(1 => $idResource)
        ));
        
        if (!$resource) {
            return $this->setJsonResponse(array('error' => 'El recurso que intenta editar no se encuentra, por favor valide la información'), 404 , 'Elemento no encontrado');
        }
        
        $contentsraw = $this->getRequestContent();
        $contentsT = json_decode($contentsraw);
//        $this->logger->log('Turned it into this: [' . print_r($contentsT, true) . ']');
        $wrapper = new PermissionSystemWrapper();
        
        try {
            $wrapper->setData($contentsT);
            $wrapper->setResource($resource);
            $wrapper->editResource();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while editing resource... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while editing resource... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
    
    /** 
    * @Route("/resources/{idResource:[0-9]+}", methods="DELETE")
    */
    public function deleteresourceAction($idResource)
    {
        $resource = Resource::findFirst(array(
            'conditions' => 'idResource = ?1',
            'bind' => array(1 => $idResource)
        ));
        
        if (!$resource) {
            return $this->setJsonResponse(array('error' => 'El recurso que intenta eliminar no se encuentra, por favor valide la información'), 404 , 'Elemento no encontrado');
        }
        
        $wrapper = new PermissionSystemWrapper();
        try {
            $wrapper->setResource($resource);
            $wrapper->deleteResource();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while deleting resource... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while deleting resource... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
	
	/**
     * 
     * @Get("/roles")
     */
    public function indexroleAction()
    {
        try {
            $wrapper = new PermissionSystemWrapper();
            $wrapper->findRoles();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (Exception $ex) {
            $this->logger->log("Exception while finding resources... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
	
	/**
     * 
     * @Post("/roles")
     */
    public function newroleAction()
    {
        $contentsraw = $this->getRequestContent();
        $contentsT = json_decode($contentsraw);
//        $this->logger->log('Turned it into this: [' . print_r($contentsT, true) . ']');
        $wrapper = new PermissionSystemWrapper();
        
        try {
            $wrapper->setData($contentsT);
            $wrapper->saveRole();
            $data = $wrapper->getData();
            
            return $this->setJsonResponse($data, 200 , 'Se ha guardado el role exitosamente');
        }
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while saving role... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while role resource... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, $wrapper->getMessage());
        }
    }
	
	 /**
    * 
    * @Put("/roles/{idRole:[0-9]+}")
    */
    public function editroleAction($idRole)
    {
        $role = Role::findFirst(array(
            'conditions' => 'idRole = ?1',
            'bind' => array(1 => $idRole)
        ));
        
        if (!$role) {
            return $this->setJsonResponse(array('error' => 'El role que intenta editar no se encuentra, por favor valide la información'), 404 , 'Elemento no encontrado');
        }
        
        $contentsraw = $this->getRequestContent();
        $contentsT = json_decode($contentsraw);
//        $this->logger->log('Turned it into this: [' . print_r($contentsT, true) . ']');
        $wrapper = new PermissionSystemWrapper();
        
        try {
            $wrapper->setData($contentsT);
            $wrapper->setRole($role);
            $wrapper->editRole();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while editing role... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while editing role... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
	
	/** 
    * @Route("/roles/{idRole:[0-9]+}", methods="DELETE")
    */
    public function deleteroleAction($idRole)
    {
		$role = Role::findFirst(array(
            'conditions' => 'idRole = ?1',
            'bind' => array(1 => $idRole)
        ));
        
        if (!$role) {
            return $this->setJsonResponse(array('error' => 'El role que intenta eliminar no se encuentra, por favor valide la información'), 404 , 'Elemento no encontrado');
        }
        
        $wrapper = new PermissionSystemWrapper();
		
        try {
            $wrapper->setRole($role);
            $wrapper->deleteRole();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while deleting role... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while deleting role... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
	
	/**
     * 
     * @Get("/actions")
     */
    public function indexactionAction()
    {
        try {
            $wrapper = new PermissionSystemWrapper();
            $wrapper->findResources();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (Exception $ex) {
            $this->logger->log("Exception while finding actions... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
	
	/**
     * 
     * @Post("/actions")
     */
    public function newactionAction()
    {
        $contentsraw = $this->getRequestContent();
        $contentsT = json_decode($contentsraw);
//        $this->logger->log('Turned it into this: [' . print_r($contentsT, true) . ']');
        $wrapper = new PermissionSystemWrapper();
        
        try {
            $wrapper->setData($contentsT);
            $wrapper->saveAction();
            $data = $wrapper->getData();
            
            return $this->setJsonResponse($data, 200 , 'Se ha guardado el role exitosamente');
        }
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while saving role... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while role resource... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, $wrapper->getMessage());
        }
    }
	
	 /**
    * 
    * @Put("/actions/{idAction:[0-9]+}")
    */
    public function editactionAction($idAction)
    {
        $action = Action::findFirst(array(
            'conditions' => 'idAction = ?1',
            'bind' => array(1 => $idAction)
        ));
        
        if (!$action) {
            return $this->setJsonResponse(array('error' => 'La acción que intenta editar no se encuentra, por favor valide la información'), 404 , 'Elemento no encontrado');
        }
        
        $contentsraw = $this->getRequestContent();
        $contentsT = json_decode($contentsraw);
//        $this->logger->log('Turned it into this: [' . print_r($contentsT, true) . ']');
        $wrapper = new PermissionSystemWrapper();
        
        try {
            $wrapper->setData($contentsT);
            $wrapper->setAction($action);
            $wrapper->editAction();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while editing action... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while editing action... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
	
	/** 
    * @Route("/actions/{idAction:[0-9]+}", methods="DELETE")
    */
    public function deleteactionAction($idAction)
    {
		$action = Action::findFirst(array(
            'conditions' => 'idAction = ?1',
            'bind' => array(1 => $idAction)
        ));
        
        if (!$action) {
            return $this->setJsonResponse(array('error' => 'La acción que intenta editar no se encuentra, por favor valide la información'), 404 , 'Elemento no encontrado');
        }
        
        $wrapper = new PermissionSystemWrapper();
		
        try {
            $wrapper->setAction($action);
            $wrapper->deleteAction();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (InvalidArgumentException $ex) {
            $this->logger->log("Exception while deleting action... {$ex}");
            return $this->setJsonResponse(array('error' => $wrapper->getMessage()), 400 , $wrapper->getMessage());
        }
        catch (Exception $ex) {
            $this->logger->log("Exception while deleting action... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
    }
	
	/**
     * 
     * @Get("/relationships")
     */
	public function getrelationshipsAction()
	{
		try {
            $wrapper = new PermissionSystemWrapper();
            $wrapper->findRelationships();
            
            return $this->setJsonResponse($wrapper->getData(), 200); 
        } 
        catch (Exception $ex) {
            $this->logger->log("Exception while finding resources... {$ex}");
            return $this->setJsonResponse(array('error' => 'Ha ocurrido un error, contacte al administrador'), 500, 'Ha ocurrido un error');
        }
	}
}
