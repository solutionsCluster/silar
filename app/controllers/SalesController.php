<?php

class SalesController extends ControllerBase {

    public function indexAction() {
		$account = $this->user->account;
		$object = new stdClass();
		$object->idAccount = $account->idAccount;
		$object->module = 'sales';
		$object->status = 'active';

		$reports = $this->getAvailableReports($object);
		
        $this->view->setVar('reports', $reports);
    }

    public function showreportAction($idReport) {
		$account = $this->user->account;
		$object = new stdClass();
		$object->idAccount = $account->idAccount;
		$object->module = 'sales';
		$object->idReport = $idReport;
		$object->status = 'active';

		$report = $this->validateReportAvailable($object);

        if (!$report) {
            $this->flashSession->error("Reporte no encontrado, por favor valide la información");
            $a= $this->response->redirect("sales/index");
print($a); die('..');
        }
		
        $this->view->setVar('report', $report);
    }
}
