<?php

class ControllerBase extends \Phalcon\Mvc\Controller
{
    protected $_isJsonResponse = false;
    
    public function initialize()
    {
//    	if (isset($this->userObject)) {
            $this->user = $this->userObject;
//    	}
    }
    
    /**
     * Llamar este metodo para enviar respuestas en modo JSON
     * @param string $content
     * @param int $status
     * @param string $message
     * @return \Phalcon\Http\ResponseInterface
     */
    public function setJsonResponse($content, $status = 200, $message = '') 
    {
        $this->view->disable();

        $this->_isJsonResponse = true;
        $this->response->setContentType('application/json', 'UTF-8');

        if ($status != 200) {
            $this->response->setStatusCode($status, $message);
        }
        
        if (is_array($content)) {
            $content = json_encode($content);
        }
        
        $this->response->setContent($content);
        return $this->response;
    }
        
    /**
     * Retorna el contenido POST de un Request desde 
     * un objeto inyectado o directamente desde el request
     */
    public function getRequestContent()
    {
        if(isset($this->requestContent->content) && $this->requestContent) {
            return $this->requestContent->content;
        }
        else {
            return $this->request->getRawBody();
        }
    }
    
    public function checkPassword($pass1, $pass2)
    {
        $pass1 = trim($pass1);
        $pass2 = trim($pass2);

        if(empty($pass1) || empty($pass2)) {
            $this->flashSession->error("Hay campos vacíos, por favor valide la información");
            return false;
        }
        
        if(\strlen($pass1) < 8 || \strlen($pass1) > 40) {
            $this->flashSession->error("La contraseña es muy corta, debe tener al menos 8 caracteres y máximo 40");
            return false;
        }
        
        if ($pass1 != $pass2) {
            $this->flashSession->error("Las contraseñas no coinciden, por favor valide la información");
            return false;
        }
        
        return true;
    }
	
	public function getAllAvailableReports($object)
	{
		$sql = "SELECT DISTINCT r.idReport AS idReport, r.name AS name, r.description AS description, r.code AS code
				FROM Pxa AS pa
					JOIN Pxr AS pr ON (pr.idPaymentplan = pa.idPaymentplan)
					JOIN Report AS r ON (r.idReport = pr.idReport)
				WHERE pa.idAccount = :idAccount: 
					AND pa.start <= :time: 
					AND pa.end >= :time:
					AND pa.status = :status:";
		
		$query = $this->modelsManager->createQuery($sql);
		
		$report = $query->execute(array(
			'idAccount' => $object->idAccount,
			'time' => time(),
			'status' => $object->status,
		));
		
		return $report;
	}
	
	public function getAvailableReports($object)
	{
		$sql = "SELECT DISTINCT r.idReport AS idReport, r.name AS name, r.description AS description, r.code AS code
				FROM Pxa AS pa
					JOIN Pxr AS pr ON (pr.idPaymentplan = pa.idPaymentplan)
					JOIN Report AS r ON (r.idReport = pr.idReport)
				WHERE pa.idAccount = :idAccount: 
					AND pa.start <= :time: 
					AND pa.end >= :time: 
					AND r.module = :module: 
					AND pa.status = :status:";
		
		$query = $this->modelsManager->createQuery($sql);
		
		$report = $query->execute(array(
			'idAccount' => $object->idAccount,
			'time' => time(),
			'module' => $object->module,
			'status' => $object->status,
		));
		
		return $report;
	}
	
	public function validateReportAvailable($object)
	{
		$sql = "SELECT DISTINCT r.idReport AS idReport, r.name AS name, r.description AS description, r.code AS code
				FROM Pxa AS pa
					JOIN Pxr AS pr ON (pr.idPaymentplan = pa.idPaymentplan AND pr.idReport = :idReport:)
					JOIN Report AS r ON (r.idReport = pr.idReport)
				WHERE pa.idAccount = :idAccount: 
					AND pa.start <= :time: 
					AND pa.end >= :time:  
					AND pa.status = :status:
					AND r.module = :module:";
		
		$query = $this->modelsManager->createQuery($sql);
		
		$report = $query->execute(array(
			'idAccount' => $object->idAccount,
			'time' => time(),
			'module' => $object->module,
			'idReport' => $object->idReport,
			'status' => $object->status,
		));
		
		if (isset($report[0])) {
			return $report[0];
		}
		
		return false;
	}
	
	public function getSQL($account, $report, $object) {
		switch ($account->database) {
			case 'firebird':
				$SQLCreator = new \Silar\Misc\FirebirdSQLCreator();
				$SQLCreator->setReport($report);
				$SQLCreator->createSQL($object);
				$sql = $SQLCreator->getSQL();
				break;	
		}
		
		return $sql;
	}
	
	
	public function getResult($account, $sql) {
		switch ($account->database) {
			case 'firebird':
				$fconnector = new \Silar\Misc\FirebirdConnector();
				$fconnector->setAccount($account);
				$fconnector->executeQuery($sql);
				$result = $fconnector->getResult();
				break;
		}
		
		return $result;
	}
	
	public function getData($account, $report, $result, $object) {
		switch ($account->database) {
			case 'firebird':
				$modeler = new \Silar\Misc\SourceModeler();
				$modeler->setReport($report);
				$modeler->setData($result);
				$modeler->setFilter($object);
				$modeler->model();
				$data = $modeler->getModeledData();
				break;
		}
		
		return $data;
	}
	
	public function getReport($result, $object, $account, $report) {
		$excel = new \Silar\Misc\PHPExcelConnector();
		$excel->setData($result);
		$excel->setFilter($object);
		$excel->setAccount($account);
		$excel->setReport($report);
		$excel->createReport();
		$tmp = $excel->getReportData();
		
		return $tmp;
	}
}
