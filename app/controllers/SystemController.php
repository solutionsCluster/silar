<?php
class SystemController extends ControllerBase
{
	public function indexAction()
	{
		
	}
	
	public function configureAction()
	{
		$configContent = "";
		$configFile = fopen("../app/config/configuration.ini", "r") or exit("Unable to open file!");
		
		while (!feof($configFile)) {
			$configContent .= fgets($configFile);
		}
		
		fclose($configFile);

		$this->view->setVar("config", $configContent);
		
		if ($this->request->isPost()) {
			$configData = $this->request->getPost('configData');
			
			if (empty($configData) || trim($configData) === '') {
				return $this->setJsonResponse(array('msg' => 'No ha enviado datos, por favor verifique la información'), 400 , 'failed');
			}
			
			try {
				$config = fopen("../app/config/configuration.ini", "w") or exit("Unable to open file!");
				$fwrite = fwrite($config, $configData);

				if (!$fwrite) {
					return $this->setJsonResponse(array('msg' => 'Ha ocurrido un error mientras se editaba el archivo de configuración'), 500 , 'failed');
				}
				else {
					return $this->setJsonResponse(array('msg' => 'Se ha editado el archivo de configuración exitosamente'), 200 , 'success');
				}
				fclose($config);
			}
			catch (Exception $e) {
				$this->logger->log("Exception: {$e}");
				return $this->setJsonResponse(array('msg' => 'Ha ocurrido un error mientras se editaba el archivo de configuración'), 500 , 'failed');
			}
		}
	}
}