<?php

class CiuucodeController extends ControllerBase
{
	public function indexAction()
	{
		$currentPage = $this->request->getQuery('page', null, 1); // GET

		$builder = $this->modelsManager->createBuilder()
			->from('Ciuu')
			->orderBy('created');

		$paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
			"builder" => $builder,
			"limit"=> 30,
			"page" => $currentPage
		));
		
		$page = $paginator->getPaginate();
		
		$this->view->setVar("page", $page);
	}

	public function newAction()
	{
		$ciuu = new Ciuu();
		$form = new CiuuCodeForm($ciuu);
		
		if($this->request->isPost()) {
			$form->bind($this->request->getPost(), $ciuu);
			$ciuu->created = time();
			$ciuu->updated = time();

			if ($form->isValid() && $ciuu->save()) {
				$this->flashSession->success("Se ha agregado la actividad economica a la lista exitosamente");
				return $this->response->redirect("ciuucode/index");
			}

			foreach ($ciuu->getMessages() as $msg) {
				$this->flashSession->error($msg);
			}
		}

		$this->view->CiuuCodeForm = $form;
	}

	public function deleteAction($id)
	{
		$ciuu = Ciuu::findFirst(array(
			'conditions' => 'idCiuu = ?1',
			'bind' => array(1 => $id)
		));

		if ($ciuu) {
			try {
				if (!$ciuu->delete()) {
					foreach ($ciuu->getMessages() as $msg) {
						$this->logger->log("Error while deleting ciuu... {$msg}");
					}

					$this->flashSession->error('Ocurrio un error mientras se eliminaba la actividad economica, por favor contacte al administrador');
				}
				$this->flashSession->success('Se ha eliminado la actividad economica exitosamente');
			}	
			catch(Exception $ex) {
				$this->logger->log($ex);
				$this->flashSession->error('Ocurrio un error mientras se eliminaba la actividad economica, por favor contacte al administrador');
			}
			
			
		}
		else {
			$this->flashSession->error('La actividad economica que desea eliminar no existe, por favor valide la información');
		}

		return $this->response->redirect('ciuucode');
	}

	public function editAction($id)
	{
		$ciuu = Ciuu::findFirst(array(
			"conditions" => "idCiuu = ?1",
			"bind" => array(1 => $id)
		));

		if (!$ciuu) {
			$this->flashSession->warning('La actividad economica que desea editar no existe, por favor valide la información');
			return $this->response->redirect('ciuucode');
		}

		$form = new CiuuCodeForm($ciuu);

		if ($this->request->isPost()) {
			$form->bind($this->request->getPost(), $ciuu);

			$ciuu->updated = time();
			
			if ($form->isValid() && $ciuu->save()) {
				$this->flashSession->success('Se ha editado la actividad economica exitosamente');
				return $this->response->redirect("ciuucode");
			}
			
			foreach ($ciuu->getMessages() as $msg) {
				$this->flashSession->error($msg);
			}
		}

		$this->view->ciuuCode = $form;
		$this->view->setVar("ciuu", $ciuu);
	}
}