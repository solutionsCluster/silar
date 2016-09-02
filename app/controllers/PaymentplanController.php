<?php

class PaymentplanController extends ControllerBase
{
    public $reports;
    
    public function indexAction()
    {
        $currentPage = $this->request->getQuery('page', null, 1); // GET

        $builder = $this->modelsManager->createBuilder()
            ->from('Paymentplan')
            ->leftJoin('Pxr', 'Paymentplan.idPaymentplan = Pxr.idPaymentplan')
            ->groupBy('Paymentplan.idPaymentplan')
            ->orderBy('Paymentplan.created');

        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $builder,
            "limit"=> 30,
            "page" => $currentPage
        ));

        $page = $paginator->getPaginate();
        
        $reports = Report::find();
        
        $this->view->setVar("page", $page);
        $this->view->setVar("reports", $reports);
    }

    public function newAction()
    {
        $payment = new Paymentplan();
        $form = new PaymentplanForm($payment);

        if($this->request->isPost()) {
            $form->bind($this->request->getPost(), $payment);
            $reports = $form->getValue('reports');
            if ($this->validateReports($reports)) {
                $status = $form->getValue('status');
                $status = trim($status);
                
                try {
                    $this->db->begin();
                    
                    $payment->status = (empty($status) || !$status ? 0 : 1);
                    $payment->created = time();
                    $payment->updated = time();

                    if ($form->isValid() && $payment->save()) {
                        if ($this->savePxr($payment)) {
                            $this->db->commit();
                            $this->flashSession->success("Se ha creado el plan de pago exitosamente");
                            return $this->response->redirect("paymentplan/index");
                        }
                    }

                    foreach ($payment->getMessages() as $msg) {
                        $this->flashSession->error($msg->getMessage());
                    }
                } 
                catch (Exception $ex) {
                    $this->db->rollback();
                    $this->logger->log("Exception while creatin payment plan... {$ex}");
                    $this->flashSession->error("Ha ocurrido un error, por favor contacte al administrador");
                }
            }
        }

        $this->view->PaymentPlanForm = $form;
    }
    
    /**
     * Recibe un arreglo con id's de reportes y verifica que existan
     * @param Array $reports
     */
    private function validateReports($reports)
    {
        if (count($reports) <= 0) {
            $this->flashSession->error("No ha asociado reportes a el plan de pago, recuerde que debe asociar al menos uno");
            return false;
        }
        
        $robjects = array();
        
        foreach ($reports as $id) {
            $report = Report::findFirst(array(
                'conditions' => 'idReport = ?1',
                'bind' => array(1 => $id)
            ));
            
            if ($report) {
                $robjects[] = $report;
            }
        }
        
        if (count($robjects) <= 0) {
            $this->flashSession->error("Ha enviado identificadores de reporte que no existen, esto puede deberse a que se han eliminado los reportes, mientras usted crea este plan de pago, por favor valide la información");
            return false;
        }
        
        $this->reports = $robjects;
        return true;
    }
    
    private function savePxr(Paymentplan $payment)
    {
        foreach ($this->reports as $report) {
            $pxr = new Pxr();
            $pxr->idPaymentplan = $payment->idPaymentplan;
            $pxr->idReport = $report->idReport;
            $pxr->created = time();
            
            if (!$pxr->save()) {
                foreach ($pxr->getMessages() as $msg) {
                    $this->logger->log("Error while saving pxr... {$msg->getMessage()}");
                    throw new Exception("Exception while saving pxr");
                }
            }
        }
        
        return true;
    }
    
    public function deleteAction($id)
    {
        $payment = Paymentplan::findFirst(array(
            'conditions' => 'idPaymentplan = ?1',
            'bind' => array(1 => $id)
        ));

        if (!$payment) {
            $this->flashSession->error('El plan de pago que desea eliminar no existe, por favor valide la información');
            return $this->response->redirect('Paymentplan');
        }    
        
        try {
            if (!$payment->delete()) {
                foreach ($payment->getMessages() as $msg) {
                    $this->logger->log("Error while deleting Paymentplan... {$msg}");
                }

                $this->flashSession->error('Ocurrio un error mientras se eliminaba el plan de pago, por favor contacte al administrador');
            }
            $this->flashSession->warning('Se ha eliminado el plan de pago exitosamente');
        }	
        catch (Exception $ex) {
            $this->logger->log($ex);
            $this->flashSession->error('Ocurrió un error mientras se eliminaba el plan de pago, por favor contacte al administrador');
        }
        
        return $this->response->redirect('Paymentplan');
    }

    public function editAction($id)
    {
        $payment = Paymentplan::findFirst(array(
            "conditions" => "idPaymentplan = ?1",
            "bind" => array(1 => $id)
        ));

        if (!$payment) {
            $this->flashSession->warning('El plan de pago que desea editar no existe, por favor valide la información');
            return $this->response->redirect('Paymentplan');
        }

        $form = new PaymentplanForm($payment);
        $pxr = Pxr::findByIdPaymentplan($payment->idPaymentplan);
        
        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $payment);
            $reports = $form->getValue('reports');
            if ($this->validateReports($reports)) {
                $status = $form->getValue('status');
                $status = trim($status);
                
                try {
                    $this->db->begin();
                    
                    $payment->status = (empty($status) || !$status ? 0 : 1);
                    $payment->updated = time();

                    if ($form->isValid() && $payment->save()) {
                        if ($this->deletePxr($pxr)) {
                            if ($this->savePxr($payment)) {
                                $this->db->commit();
                                $this->flashSession->success('Se ha editado el plan de pago exitosamente');
                                return $this->response->redirect("Paymentplan");
                            }
                        }
                    }

                    foreach ($payment->getMessages() as $msg) {
                        $this->flashSession->error($msg)->getMessage();
                    }
                } 
                catch (Exception $ex) {
                    $this->db->rollback();
                    $this->logger->log("Exception while creatin payment plan... {$ex}");
                    $this->flashSession->error("Ha ocurrido un error, por favor contacte al administrador");
                }
            }
        }
        
        $reports = Report::find();
        
        $this->view->PaymentplanForm = $form;
        $this->view->setVar("payment", $payment);
        $this->view->setVar("reports", $reports);
        $this->view->setVar("pxr", $pxr);
    }
    
    private function deletePxr($pxr)
    {
        foreach ($pxr as $p) {
            if (!$p->delete()) {
                throw new Exception("Error while deleting pxr");
            }
        }
        return true;
    }
	
	public function getpaymentsplanAction()
	{
		$payments = array();
		try {
           $result = Paymentplan::find(array(
			   'conditions' => 'status = ?1',
			   'bind' => array(1 => 1)
		   ));
			
			if (count($result) > 0) {
				foreach ($result as $value) {
					$obj = new stdClass();
					$obj->id = $value->idPaymentplan;
					$obj->name = $value->name;
					
					$payments[] = $obj;
				}
			}
			
            return $this->setJsonResponse($payments, 200);
            
        } catch (Exception $ex) {
            $this->logger->log("Exception... {$ex}");
            return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
        }
	}
}