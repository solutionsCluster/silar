<?php

class IndexController extends ControllerBase
{
    public function indexAction()
    {
		$account = $this->user->account;
		$obj = new stdClass();		$obj->idAccount = $account->idAccount;
		$obj->status = 'active';

		$reports = $this->getAllAvailableReports($obj);

        $this->view->setVar('reports', $reports);
        $this->view->setVar('index', true);
	
    }
}

