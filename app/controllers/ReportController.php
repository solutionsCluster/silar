<?php

class ReportController extends ControllerBase
{
    public function indexAction()
    {
        $currentPage = $this->request->getQuery('page', null, 1); // GET
        $builder = $this->modelsManager->createBuilder()
            ->from('Report')
            ->orderBy('created');

        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $builder,
            "limit"=> 20,
            "page" => $currentPage
        ));

        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
    }
    
    public function newAction()
    {
        $report = new Report();
        $form = new ReportForm($report);

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $report);
            
            $g = $form->getValue('graphics');
            $report->graphic = (empty($g) || !$g ? 0 : 1);
            $report->created = time();
            $report->updated = time();

            if ($form->isValid() && $report->save()) {
                $this->flashSession->success("Se ha creado el reporte exitosamente");
                return $this->response->redirect("report");
            }

            foreach ($report->getMessages() as $msg) {
                $this->flashSession->error($msg->getMessage());
            }
        }
        $this->view->ReportForm = $form;
    }
    
    public function editAction($idReport)
    {
        $report = Report::findFirst(array(
            'conditions' => 'idReport = ?1',
            'bind' => array(1 => $idReport)
        ));

        if (!$report) {
            $this->flashSession->error('El reporte que desea editar no existe, por favor valide la información');
            return $this->response->redirect('report');
        }

        $form = new ReportForm($report);

        if ($this->request->isPost()) {
                $form->bind($this->request->getPost(), $report);
                $g = $form->getValue('graphics');
                $report->graphic = (empty($g) || !$g ? 0 : 1);
                $report->updated = time();

                if ($form->isValid() && $report->save()) {
                    $this->flashSession->success("Se ha editado el reporte exitosamente");
                    return $this->response->redirect("report");
                }

                foreach ($report->getMessages() as $msg) {
                    $this->flashSession->error($msg->getMessage());
                }
        }

        $this->view->ReportForm = $form;
        $this->view->setVar("report", $report);
    }
    
    public function deleteAction($idReport)
    {
        $report = Report::findFirst(array(
            'conditions' => 'idReport = ?1',
            'bind' => array(1 => $idReport)
        ));
        
        if (!$report) {
            $this->flashSession->error('No se ha encontrado el reporte a eliminar, por favor valide la información');
        }
        
        try {
            $report->delete();
            $this->flashSession->warning('Se ha eliminado el reporte exitosamente');
        } 
        catch (Exception $ex) {
            $this->logger->log("Exception while deleting report... {$ex}");
            $this->flashSession->error('Ha ocurrido un error contacte al adiminstrador');
        }
        
        return $this->response->redirect("report");
    }
	
	
	public function getdataforreportAction() {
        if ($this->request->isPost()) {
			$object = $this->request->getPost('object');
			$this->logger->log("Obj: " . print_r($object, true));
			$account = $this->user->account; 
			$obj = new stdClass();
			$obj->idAccount = $account->idAccount;
			$obj->module = $object['module'];
			$obj->idReport = $object['idReport'];
			$obj->status = 'active';

			$report = $this->validateReportAvailable($obj);

            if (!$report) {
                return $this->setJsonResponse(array('message' => 'Reporte no encontrado, por favor valide la información'), 404);
            }
	
            try {
		$sql = $this->getSQL($account, $report, $object); 
                if (empty($sql)) {
                    return $this->setJsonResponse(array('message' => 'Reporte no encontrado, por favor valide la información'), 404);
                }

				$result = array(); 
				if (is_array($sql)) {
					foreach ($sql as $s) {
						//print_r($account->database); die('..'); 
						$this->logger->log("SQL: {$s}");
						$result[] = $this->getResult($account, $s);
						//print_r($result );
					}
	//	die(' hola');	
				}
				else { 
					$this->logger->log("SQL: {$sql}");
					$result = $this->getResult($account, $sql);
				}
			//	print($sql);die('..');
				$data = $this->getData($account, $report, $result, $object);
				
//		print_r($data); die();		
                return $this->setJsonResponse(array('data' => $data), 200);
            } catch (Exception $ex) {
                $this->logger->log("Exception while connection with firebird database... {$ex}");
            }
        }
    }

    public function createreportAction() {
        if ($this->request->isPost()) {
			$account = $this->user->account;
            $object = $this->request->getPost('object');
			$obj = new stdClass();
			$obj->idAccount = $account->idAccount;
			$obj->module = $object['module'];
			$obj->idReport = $object['idReport'];
			$obj->status = 'active';
			
//			$this->logger->log("Obj: " . print_r($object, true));
			
			$report = $this->validateReportAvailable($obj);
			
            if (!$report) {
                return $this->setJsonResponse(array('message' => 'Reporte no encontrado, por favor valide la información'), 404);
            }

            try {
                $sql = $this->getSQL($account, $report, $object);
				
                if (empty($sql)) {
                    return $this->setJsonResponse(array('message' => 'Reporte no encontrado, por favor valide la información'), 404);
                }

				if (is_array($sql)) {
					$result = array();
					foreach ($sql as $s) {
//						$this->logger->log("SQL: {$s}");
						$result[] = $this->getResult($account, $s);
					}
				}
				else {
//					$this->logger->log("SQL: {$sql}");
					$result = $this->getResult($account, $sql);
				}
				
				$data = $this->getData($account, $report, $result, $object);
				$tmp = $this->getReport($data, $object, $account, $report);

                return $this->setJsonResponse(array('message' => $tmp->idTmpreport), 200);
            } catch (Exception $ex) {
                $this->logger->log("Exception while creating report... {$ex}");
                return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
            }
        }
    }
	
	public function downloadreportAction($idReport) 
	{
        $account = $this->user->account;
        $tmpreport = Tmpreport::findFirst(array(
                    'conditions' => 'idTmpreport = ?1 AND idAccount = ?2',
                    'bind' => array(1 => $idReport,
                        2 => $account->idAccount)
        ));

        if (!$tmpreport) {
            return $this->response->redirect('error');
        }

        $this->view->disable();

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$tmpreport->name}");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Pragma: no-cache');

        $folder = "{$this->path->path}{$this->path->tmpfolder}{$this->user->account->idAccount}/{$tmpreport->name}";
        readfile($folder);
    }
}

