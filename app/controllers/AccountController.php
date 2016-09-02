<?php

class AccountController extends ControllerBase
{
    public function indexAction()
    {
        $currentPage = $this->request->getQuery('page', null, 1); // GET

        $builder = $this->modelsManager->createBuilder()
                ->from('Account')
				->join('Firebird', 'Firebird.idFirebird = Account.idFirebird')
				->join('Ciuu', 'Ciuu.idCiuu = Account.idCiuu')
                ->orderBy('Account.created');

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
        $account = new Account();
        $user = new User();
        $aform = new AccountForm($account);
		$uform = new UserForm($user, $this->user);

        if ($this->request->isPost()) {
            $aform->bind($this->request->getPost(), $account);
            $uform->bind($this->request->getPost(), $user);

            $pass1 = $uform->getValue('password1');
            $pass2 = $uform->getValue('password2');

            if ($this->checkPassword($pass1, $pass2)) {
                $status = $aform->getValue('astatus');
                $name = $aform->getValue('aname');

                $account->status = (empty($status) || !$status ? 0 : 1);
                $account->name = $name;
                $account->created = time();
                $account->updated = time();
                $this->db->begin();

                if ($aform->isValid() && $account->save()) {
                    $status = $aform->getValue('status');
                    $user->idAccount = $account->idAccount;
                    $user->password = $this->hash->hash($pass1);
                    $user->status = (empty($status) || !$status ? 0 : 1);
                    $user->created = time();
                    $user->updated = time();

                    if ($uform->isValid() && $user->save()) {
                        $this->db->commit();
                        $this->flashSession->success("Se ha guardado la cuenta exitosamente");
                        return $this->response->redirect("account");
                    }
                }

                foreach ($account->getMessages() as $msg) {
                    $this->flashSession->error($msg);
                }

                foreach ($user->getMessages() as $msg) {
                    $this->flashSession->error($msg);
                }

                $this->db->rollback();
            }
        }

        $this->view->AccountForm = $aform;
        $this->view->UserForm = $uform;
    }

    public function deleteAction()
    {

    }

    public function editAction($id)
    {
        $account = Account::findFirst(array(
            "conditions" => "idAccount = ?1",
            "bind" => array(1 => $id)
        ));

        if (!$account) {
            $this->flashSession->warning('La cuenta que desea editar no existe, por favor valide la información');
            return $this->response->redirect('account');
        }

        $form = new AccountForm($account);

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $account);
            $status = $form->getValue('status2');
            
            $account->status = (empty($status) || !$status ? 0 : 1);
            $account->updated = time();

            if ($form->isValid() && $account->save()) {
                $this->flashSession->success("Se ha editado la cuenta exitosamente");
                return $this->response->redirect("account");
            }

            foreach ($account->getMessages() as $msg) {
                $this->flashSession->error($msg);
            }
        }

        $this->view->AccountForm = $form;
        $this->view->setVar("account", $account);
    }
	
    public function showusersAction($id)
    {
       $account = Account::findFirst(array(
            'conditions' => 'idAccount = ?1',
            'bind' => array(1 => $id)
        ));

        if (!$account) {
            $this->flashSession->warning("No existe la cuenta, por favor valide la información");
            return $this->response->redirect("account");
        }


        $currentPage = $this->request->getQuery('page', null, 1); // GET
        $builder = $this->modelsManager->createBuilder()
            ->from('User')
            ->join('Role', 'User.idRole = Role.idRole')
            ->where("User.idAccount = {$account->idAccount}")
            ->orderBy('User.created');

        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $builder,
            "limit"=> 30,
            "page" => $currentPage
        ));

        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
        $this->view->setVar('account', $account);
    }
    
    public function edituserAction($idAccount, $idUser)
    {
        $account = Account::findFirst(array(
            'conditions' => 'idAccount = ?1',
            'bind' => array(1 => $idAccount)
        ));
        
        if (!$account) {
            $this->flashSession->warning("No existe la cuenta, por favor valide la información");
            return $this->response->redirect("account/showusers/{$account->idAccount}");
        }
        
        $user = User::findFirst(array(
            'conditions' => 'idAccount = ?1 AND idUser = ?2',
            'bind' => array(1 => $account->idAccount,
                            2 => $idUser)
        ));
        
        if (!$user) {
            $this->flashSession->warning("No existe el usuario, por favor valide la información");
            return $this->response->redirect("account/showusers/{$account->idAccount}");
        }
        
        $this->view->setVar('user', $user);
        $this->view->setVar('account', $account);
        $form = new UserForm($user, $this->user);
        
        if ($this->request->isPost()) {   
            $form->bind($this->request->getPost(), $user);

            $username = $form->getValue('userName');

            if (strlen($username) < 4) {
                $this->flashSession->error("El nombre de usuario es muy corto, debe tener al menos 4 caracteres");
            }
            else {
                $email = strtolower($form->getValue('email'));
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->flashSession->error("La dirección de correo ingresada es invalida, por favor verifique la información");
                }
                else {
                    $user->email = $email;
                    if (!$form->isValid() OR !$user->save()) {
                        foreach ($user->getMessages() as $msg) {
                            $this->flashSession->error($msg);
                        }
                    }
                    else {
                        $this->flashSession->success('Se ha editado exitosamente el usuario <strong>' . $user->userName . '</strong> de la cuenta <strong>' . $account->name . '</strong>');
                        return $this->response->redirect("account/showusers/{$user->idAccount}");
                    }
                }
            }
        }
        $this->view->UserForm = $form;
    }
    
    public function changeuserstatusAction($idAccount, $idUser)
    {
        if ($this->request->isPost()) {
            $account = Account::findFirst(array(
                'conditions' => 'idAccount = ?1',
                'bind' => array(1 => $idAccount)
            ));
            
            if (!$account) {
                return $this->setJsonResponse(array('error' => "No se ha encontrado la cuenta, por favor verifique la información"), 404);
            }
            
            $user = User::findFirst(array(
                'conditions' => 'idAccount = ?1 AND idUser = ?2',
                'bind' => array(1 => $idAccount,
                                2 => $idUser)
            ));
		
            if (!$user) {
                return $this->setJsonResponse(array('error' => "No se ha encontrado el usuario, por favor verifique la información"), 404);
            }
            
            $status = $user->status;
            $user->status = ($status == 1 ? 0 : 1);
            $this->logger->log($user->status);
            if (!$user->save()) {
                foreach ($user->getMessages() as $msg) {
                    $this->logger->log("Error: {$msg}");
                }
                return $this->setJsonResponse(array('error' => "Ha ocurrido un error, contacte con el administrador"), 500);
            }
            
            return $this->setJsonResponse(array('success' => "Se ha cambiado el estado del usuario exitosamente"), 200);
	}
    }
    
    public function changepasswordAction($idAccount, $idUser)
    {
        $account = Account::findFirst(array(
            'conditions' => 'idAccount = ?1',
            'bind' => array(1 => $idAccount)
        ));

        if (!$account) {
            $this->flashSession->error("No se encuentra la cuenta, por favor valide la información");
            return $this->response->redirect("account");
        }

        $user = User::findFirst(array(
            'conditions' => 'idAccount = ?1 AND idUser = ?2',
            'bind' => array(1 => $idAccount,
                            2 => $idUser)
        ));

        if (!$user) {
            $this->flashSession->error("No se encuentra el usuario, por favor valide la información");
            return $this->response->redirect("account/showusers/{$idAccount}");
        }
            
        if ($this->request->isPost()) {
            $pass1 = $content = $this->request->getPost("pass1");
            $pass2 = $content = $this->request->getPost("pass2");
            
            if ($this->checkPassword($pass1, $pass2)) {
                $user->password = $this->hash->hash($pass1);
                        
                if ($user->save()) {
                    $this->flashSession->success("Se ha cambiado la contraseña del usuario <strong>{$user->userName}</strong> exitosamente");
                    return $this->response->redirect("account/showusers/{$idAccount}/{$idUser}");
                }
                
                foreach ($user->getMessages() as $msg) {
                    $this->flashSession->error("Ha ocurrido un error: {$msg}");
                }
            }
        }
        
        $this->view->setVar('user', $user);
        $this->view->setVar('account', $account);
    }
    
    public function newuserAction($idAccount) 
    {
        $account = Account::findFirst(array(
            'conditions' => 'idAccount = ?1',
            'bind' => array(1 => $idAccount)
        ));
        
        if (!$account) {
            $this->flashSession->error("No se encuentra la cuenta, por favor valide la información");
            return $this->response->redirect("account");
        }
        
        $user = new User();
        $form = new UserForm($user, $this->user);

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $user);
            $pass1 = $form->getValue('password1');
            $pass2 = $form->getValue('password2');
            $status = $form->getValue('status');
            
            if ($this->checkPassword($pass1, $pass2)) {
                $user->idAccount = $account->idAccount;
                $user->password = $this->hash->hash($pass1);
                $user->status = $status;
                $user->created = time();
                $user->updated = time();

                if ($form->isValid() && $user->save()) {
                    $this->flashSession->success("Se ha creado el usuario exitosamente");
                    return $this->response->redirect("account/showusers/{$idAccount}");
                }

                foreach ($user->getMessages() as $msg) {
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }
        $this->view->UserForm = $form;
        $this->view->setVar('account', $account);
    }
    
    public function addpaymentplanAction($idAccount)
    {
        $account = Account::findFirst(array(
            'conditions' => 'idAccount = ?1',
            'bind' => array(1 => $idAccount)
        ));
        
        if (!$account) {
            $this->flashSession->error("No se encuentra la cuenta, por favor valide la información");
            return $this->response->redirect("account");
        }
        
        $this->view->setVar('account', $account);
    }
	
	public function getpaymentsplanAction($idAccount)
	{
		$account = Account::findFirst(array(
            'conditions' => 'idAccount = ?1',
            'bind' => array(1 => $idAccount)
        ));
		
		if (!$account) {
            return $this->setJsonResponse(array('message' => 'No se encuentra la cuenta, por favor valide la información'), 404);
        }
		
		$payments = array();
		try {
            $sql = "SELECT p.idPaymentplan AS id, p.name AS name, 'a.start' AS inicio, 'a.end' AS fin, a.status AS status
					FROM Pxa AS a
						JOIN Paymentplan AS p ON p.idPaymentplan = a.idPaymentplan
					WHERE a.idAccount = :id:";
            
			$result = $this->modelsManager->executeQuery($sql, array(
				'id' => $account->idAccount
			));
			
			if (count($result) > 0) {
				foreach ($result as $value) {
					$obj = new stdClass();
					$obj->id = $value->id;
					$obj->name = $value->name;
					$obj->inicio = date('d/m/Y H:m', $value->inicio);
					$obj->fin = date('d/m/Y H:m', $value->fin);
					$obj->status = $value->status;
					
					$payments[] = $obj;
				}
			}
			
            return $this->setJsonResponse($payments, 200);
            
        } catch (Exception $ex) {
            $this->logger->log("Exception... {$ex}");
            return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
        }
	}
	
	public function setpaymentplanAction($idAccount)
	{
		$account = Account::findFirst(array(
            'conditions' => 'idAccount = ?1',
            'bind' => array(1 => $idAccount)
        ));
		
		if (!$account) {
            return $this->setJsonResponse(array('message' => 'No se encuentra la cuenta, por favor valide la información'), 404);
        }
		
		if ($this->request->isPost()) {
			try {
				$object = $this->request->getPost("object");
				
				$pxa = Pxa::findFirst(array(
					'conditions' => 'idAccount = ?1 AND idPaymentplan = ?2',
					'bind' => array(1 => $idAccount,
									2 => $object['id'])
				));

				if (!$pxa) {
					$pxa = new Pxa();
				}
				
				list($sday, $smonth, $syear, $shour, $sminute) = preg_split('/[\s\/|-|:]+/', $object['start']);
				list($eday, $emonth, $eyear, $ehour, $eminute) = preg_split('/[\s\/|-|:]+/', $object['end']);
				$start = mktime($shour, $sminute, 0, $smonth, $sday, $syear);
				$end = mktime($ehour, $eminute, 0, $emonth, $eday, $eyear);
				
				$pxa->idAccount = $account->idAccount;
				$pxa->idPaymentplan = $object['id'];
				$pxa->created = time();
				$pxa->updated = time();
				$pxa->start = $start;
				$pxa->end = $end;
				$pxa->status = $object['status'];
				
				if (!$pxa->save()) {
					foreach ($pxa->getMessages() as $msg) {
						$this->logger->log("Error: {$msg}");
					}
					throw new Exception('Error while saving pxa');
				}
				
				return $this->setJsonResponse(array('message' => 'Plan de pago agregado exitosamente'), 200);
			}
			catch (Exception $ex) {
				$this->logger->log("Exception... {$ex}");
				return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
			}
		}
	}
	
	public function quitpaymentplanAction($idAccount)
	{
		$account = Account::findFirst(array(
            'conditions' => 'idAccount = ?1',
            'bind' => array(1 => $idAccount)
        ));
		
		if (!$account) {
            return $this->setJsonResponse(array('message' => 'No se encuentra la cuenta, por favor valide la información'), 404);
        }
		
		if ($this->request->isPost()) {
			try {
				$object = $this->request->getPost("object");
				$pxa = Pxa::findFirst(array(
					'conditions' => 'idAccount = ?1 AND idPaymentplan = ?2',
					'bind' => array(1 => $idAccount,
									2 => $object['id'])
				));

				if (!$pxa) {
					throw new Exception("Pxa not found!");
				}
				
				$pxa->delete();
				
				return $this->setJsonResponse(array('message' => 'Plan de pago removido exitosamente'), 200);
			}
			catch (Exception $ex) {
				$this->logger->log("Exception... {$ex}");
				return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
			}
		}
	}
}
