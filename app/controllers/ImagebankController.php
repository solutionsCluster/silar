<?php 

class ImagebankController extends ControllerBase
{
	public function indexAction()
	{
		$currentPage = $this->request->getQuery('page', null, 1); // GET

		$builder = $this->modelsManager->createBuilder()
			->from('Imagebank')
			->orderBy('created');

		$paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
			"builder" => $builder,
			"limit"=> 15,
			"page" => $currentPage
		));
		
		$page = $paginator->getPaginate();
		
		$this->view->setVar("page", $page);
	}

	public function newloginimageAction()
	{
		if ($this->request->isPost()) {
			if (empty($_FILES['file']['name'])) {
				$this->flashSession->error("No ha enviado ningún archivo, por favor valide la información");
				return $this->response->redirect('imagebank/newloginimage');
			}

			if ($_FILES['file']["error"] > 0) {
				$this->flashSession->error("Ha ocurrido un error, por favor contacte al administrador");
				return $this->response->redirect('imagebank/newloginimage');
			}

			$name = $_FILES['file']['name'];
			$size = $_FILES['file']['size'];
			$type = $_FILES['file']['type'];
			$tmp_dir = $_FILES['file']['tmp_name'];
			
			$data = new stdClass();
			$data->name = $name;
			$data->originalName = $name;
			$data->size = $size;
			$data->type = $type;
			$data->tmpDir = $tmp_dir;

			try {
				$dir = $this->imgbnk->loginimages;
				$uploader = new \Silar\Misc\Uploader();
				$uploader->setData($data);
				$uploader->validateExt(array('jpeg', 'png', 'gif', 'jpg', 'PNG', 'JPEG', 'JPG', 'GIF'));
				$uploader->validateSize($size);
				$uploader->uploadImage($dir, 195, 270);
				
				$this->flashSession->success("Se ha cargado la imagen exitosamente");
				return $this->response->redirect('imagebank');
			}
			catch (Exception $e) {
				$mb = $this->bytesToMegabytes($this->imgbnk->systemsize);
				$this->flashSession->error("Ha ocurrido un error mientras se cargaba la imagen, asegurese de que sea un archivo valido y tenga un peso no mayor a {$mb} MegaBytes");
				$this->logger->log("Exception: {$e}");
				return $this->response->redirect('imagebank/newloginimage');
			}
		}		
	}

	public function deleteloginimageAction($id)
	{
		$imagebank = Imagebank::findFirst(array(
			'conditions' => 'idImagebank = ?1',
			'bind' => array(1 => $id)
		));

		if ($imagebank) {
			if (!$imagebank->delete()) {
				foreach ($imagebank as $msg) {
					$this->logger->log("Could not delete image from db... {$msg}");
				}

				$this->flashSession->error("Ocurrió un error mientras se eliminaba la imagen, por favor contacte al administrador");
				return $this->response->redirect('imagebank');
			}


			$dir = $this->imgbnk->loginimages . $imagebank->name;

			try {
				$uploader = new \Silar\Misc\Uploader();
				$uploader->deleteFileFromServer($dir);

				$this->flashSession->success("Se ha eliminado la imagen exitosamente");
				return $this->response->redirect('imagebank');
			}
			catch (Exception $e) {
				$this->logger->log("Exception: {$e}");

				$this->flashSession->error("Ocurrió un error mientras se eliminaba la imagen, por favor contacte al administrador");
				return $this->response->redirect('imagebank');
			}
		}

		$this->flashSession->error("La imagen a eliminar no existe");
		return $this->response->redirect('imagebank');
	}

	private function bytesToMegabytes($bytes)
	{
		$kb = $bytes/1024;
		$mb = $kb/1024;
		$mb = explode('.', $mb);

		return $mb[0];
	}
}
