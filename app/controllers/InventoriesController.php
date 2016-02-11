<?php

class InventoriesController extends ControllerBase
{
    public function indexAction() {
		$account = $this->user->account;
		$object = new stdClass();
		$object->idAccount = $account->idAccount;
		$object->module = 'inventories';
		$object->status = 'active';

		$reports = $this->getAvailableReports($object);
		
        $this->view->setVar('reports', $reports);
	}
	
	public function showreportAction($idReport) {
		$account = $this->user->account;
		$object = new stdClass();
		$object->idAccount = $account->idAccount;
		$object->module = 'inventories';
		$object->idReport = $idReport;
		$object->status = 'active';

		$report = $this->validateReportAvailable($object);

        if (!$report) {
            $this->flashSession->error("Reporte no encontrado, por favor valide la información");
            return $this->response->redirect("portfolio/index");
        }

        $this->view->setVar('report', $report);
    }
}
