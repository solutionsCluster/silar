<?php

class SessionController extends ControllerBase
{
    public function loginAction()
    {

    }
	
    public function validatesessionAction()
    {
        $msg = "Usuario o contraseña incorrecta";

        if ($this->request->isPost()) {
//            if ($this->security->checkToken()) {
                $login = $this->request->getPost("userName");
                $password = $this->request->getPost("password");

                $user = User::findFirst(array(
                    "userName = ?0",
                    "bind" => array($login)
                ));


                if ($user && $this->hash->checkHash($password, $user->password)) {
//                if ($user) {
                    if ($user->status == 1) {
                        $account = Account::findFirstByIdAccount($user->idAccount);

                        if ($account && $account->status == 1) {
                            $this->session->set('user-id', $user->idUser);
                            $this->session->set('authenticated', true);

                            $this->user = $user;

                            return $this->response->redirect("");
                        }
                        else {
                            $msg = "La cuenta ha sido bloqueada, por favor contacte al administrador";
                        }
                    }
                    else {
                        $msg = "El usuario ha sido bloqueado, por favor contacte al administrador";
                    }   
                }
//            }
        }

        $this->flashSession->error($msg);
        return $this->response->redirect("session/login");
    }

    public function logoutAction()
    {
        $this->session->remove("user-name");
        $this->session->destroy();
	
        $this->response->redirect('session/login');
    }
    
    public function recoverpasswordAction()
    {
        if ($this->request->isPost()) {
            $email = $this->request->getPost("email");

            $user = User::findFirst(array(
                    'conditions' => 'email = ?1',
                    'bind' => array(1 => $email)
            ));

            if ($user) {
                $cod = uniqid();
                $url = $this->urlManager->getBaseUrl(true);
                $url .= "session/resetpassword/{$cod}";

                $recover = new Tmprecoverpassword();
                $recover->idTmprecoverpassword = $cod;
                $recover->idUser = $user->idUser;
                $recover->url = $url;
                $recover->date = time();

                if (!$recover->save()) {
                    $this->logger->log("Error while saving tmp recover password url {$user->idUser}/{$user->username}");
                    foreach ($recover->getMessages() as $msg) {
                        $this->logger->log('Msg: ' . $msg);
                    }
                    
                    $this->flashSession->error('Ha ocurrido un error contacte al administrador');
                }
                else {
                    $link = '<a href="' . $url . '" style="text-decoration: underline;">Click aqui</a>';
                    
                    try {
                        $message = new \Silar\Misc\AdministrativeMessages();
						$message->setSmtp($this->smtpsupport);
                        $message->setSubject("Instrucciones para recuperar la contraseña de su cuenta en Cluster Solutions - Silar");
                        $message->setTo(array($user->email => "{$user->name} {$user->lastName}"));
                        $message->setReplyTo("noreply@clustersolutions.net");
                        $message->searchMessage('reset-password');
                        $message->replaceVariables(array('%%resetpassword%%'), array($link));
                        $message->sendMessage();
                    }
                    catch (Exception $ex) {
                        $this->logger->log("Exception: {$ex}");
                        $this->flashSession->error('Ha ocurrido un error contacte al administrador');
                    }
                }
            }
            
            $this->flashSession->success('Se ha enviado un correo electronico con instrucciones para recuperar la contraseña');
            return $this->response->redirect('session/login');
        }
    }
    
    public function resetpasswordAction($unique)
    {
        if ($this->request->isPost()) {
            $this->logger->log("Is Post");
            $uniq = $this->request->getPost("uniq");
	
            $url = Tmprecoverpassword::findFirst(array(
                'conditions' => 'idTmprecoverpassword = ?1',
                'bind' => array(1 => $unique)
            ));
			
            $time = strtotime("-30 minutes");
			
            if ($url && $url->date >= $time) {
                $pass = $this->request->getPost("pass");
                $pass2 = $this->request->getPost("pass2");
                
                $pass = trim($pass);
                $pass2 = trim($pass2);
                
                if (empty($pass)||empty($pass2)){
                    $this->flashSession->error("Ha enviado campos vacíos, por favor verifique la información");
                    return $this->response->redirect("session/resetpassword/{$uniq}");
                }
                else if (strlen($pass) < 8 || strlen($pass) > 40) {
                    $this->flashSession->error("La contraseña es muy corta o muy larga, esta debe tener mínimo 8 y máximo 40 caracteres, por favor verifique la información");
                    return $this->response->redirect("session/resetpassword/{$uniq}");
                }	
                else if ($pass != $pass2) {
                    $this->flashSession->error("Las contraseñas no coinciden, por favor verifique la información");
                    return $this->response->redirect("session/resetpassword/{$uniq}");
                }
                else {
                    $idUser = $this->session->get('idUser');

                    $user = User::findFirst(array(
                        'conditions' => 'idUser = ?1',
                        'bind' => array(1 => $idUser)
                    ));

                    if ($user) {
                        $user->password = $this->hash->hash($pass);

                        if (!$user->save()) {
                            $this->flashSession->notice('Ha ocurrido un error, contacte con el administrador');
                            foreach ($user->getMessages() as $msg) {
                                $this->logger->log("Error while recovering user password {$msg}");
                                $this->logger->log("User {$user->idUser}/{$user->username}");
                                $this->flashSession->error('Ha ocurrido un error contacte al administrador');
                            }
                        }
                        else {
                            $idUser = $this->session->remove('idUser');
                            $url->delete();
                            $this->flashSession->success('Se ha restaurado la contraseña exitosamente');
                            return $this->response->redirect('session/login');
                        }
                    }
                    else {
                        return $this->response->redirect('error/link');
                    }
                }
            }
            else {
                return $this->response->redirect('error/link');
            }
	}
        
        $url = Tmprecoverpassword::findFirst(array(
            'conditions' => 'idTmprecoverpassword = ?1',
            'bind' => array(1 => $unique)
        ));

        $time = strtotime("-30 minutes");
        
        if ($url && ($url->date <= $time || $url->date >= $time)) {
            $this->session->set('idUser', $url->idUser); 
            $this->view->setVar('uniq', $unique);
        }
        else {
//            $this->traceFail("Reset pass failed because the link is invalid, do not exists or is expired id: {$unique}");
            return $this->response->redirect('error/link');
        }
    }
	
	public function loginasrootAction($idUser)
	{
		$user = User::findFirst(array(
			'conditions' => 'idUser = ?1',
			'bind' => array(1 => $idUser)
		));

		if (!$user) {
			$this->flashSession->error("No se ha podido ingresar como el usuario, porque este no existe");
			return $this->response->redirect('account/index');
		}
		
		$this->session->set('user-id', $user->idUser);
		$this->session->set('authenticated', true);
		$this->user = $user;
		return $this->response->redirect("");
	}
	
	public function logoutfromrootAction()
	{
		$uefective = $this->session->get('userefective');
		if (isset($uefective)) {
			$this->session->set('user-id', $uefective->idUser);
			$this->session->set('authenticated', true);
			$this->user = $uefective;
			$this->session->remove('userefective');
			return $this->response->redirect("");
		}
		else {
			return $this->response->redirect("error/unauthorized");
		}
		
	}
}