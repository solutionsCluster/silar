<?php

class UserController extends ControllerBase
{
    public function indexAction()
    {
        $account = $this->user->account;
        
        $currentPage = $this->request->getQuery('page', null, 1); // GET
        $builder = $this->modelsManager->createBuilder()
            ->from('User')
            ->join('Role', 'User.idRole = Role.idRole')
            ->where("User.idAccount = {$account->idAccount}")
            ->orderBy('User.created');

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
        $user = new User();
        $form = new UserForm($user, $this->user);

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $user);
            $pass1 = $form->getValue('password1');
            $pass2 = $form->getValue('password2');
            
            if ($this->checkPassword($pass1, $pass2)) {
                $status = $form->getValue('status');
                $user->idAccount = $this->user->account->idAccount;
                $user->password = $this->hash->hash($pass1);
                $user->status = $status;
                $user->created = time();
                $user->updated = time();

                if ($form->isValid() && $user->save()) {
                    $this->flashSession->success("Se ha creado el usuario exitosamente");
                    return $this->response->redirect("user");
                }

                foreach ($user->getMessages() as $msg) {
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }
        $this->view->UserForm = $form;
    }

    public function deleteAction($id)
    {
		$current = $this->user;
        $user = User::findFirst(array(
            "conditions" => "idUser = ?1",
            "bind" => array(1 => $id)
        ));

        if (!$user) {
            $this->flashSession->warning('El usuario que desea eliminar no existe, por favor valide la información');
            return $this->response->redirect('user');
        }
        
		if ($user->idUser == $current->idUser) {
            $this->flashSession->notice('El usuario que desea eliminar es el que actualmente esta en sesión, para poder eliminarlo cierre sesión e ingrese con un usuario diferente');
            return $this->response->redirect('user');
        }
		
        try {
            if (!$user->delete()) {
                foreach ($user->getMessages() as $m) {
                    throw new Exception("Error while deleting user: {$m->getMessage()}");
                }
            }
            
            $this->flashSession->success("Se ha eliminado el usuario <strong>{$user->userName}</strong> exitosamente");
            return $this->response->redirect('user');
        } 
        catch (Exception $ex) {
            $this->logger->log("Exception: {$ex}");
            $this->flashSession->error("Ha ocurrido un error mientras se eliminaba el usuario, por favor contacte al administrador");
            return $this->response->redirect('user');
        }
    }

    public function editAction($id)
    {
        $user = User::findFirst(array(
            "conditions" => "idUser = ?1",
            "bind" => array(1 => $id)
        ));

        if (!$user) {
            $this->flashSession->warning('El usuario que desea editar no existe, por favor valide la información');
            return $this->response->redirect('user');
        }

        $form = new UserForm($user, $this->user);

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $user);
            $status = $form->getValue('status2');
            
            $user->status = (empty($status) || !$status ? 0 : 1);
            $user->updated = time();

            if ($form->isValid() && $user->save()) {
                $this->flashSession->success("Se ha editado el usuario exitosamente");
                return $this->response->redirect("user");
            }

            foreach ($user->getMessages() as $msg) {
                $this->flashSession->error($msg);
            }
        }

        $this->view->UserForm = $form;
        $this->view->setVar("user", $user);
    }
    
    public function changepasswordAction($id)
    {
        $user = User::findFirst(array(
            "conditions" => "idUser = ?1",
            "bind" => array(1 => $id)
        ));

        if (!$user) {
            $this->flashSession->warning('El usuario al que desea cambiar la contraseña no existe, por favor valide la información');
            return $this->response->redirect('user');
        }
        
        if ($this->request->isPost()) {
            $pass1 = $this->request->getPost('pass1');
            $pass2 = $this->request->getPost('pass2');
            
            if ($this->checkPassword($pass1, $pass2)) {
                $user->password = $this->hash->hash($pass1);
                $user->updated = time();

                if ($user->save()) {
                    $this->flashSession->success("Se ha cambiado la contraseña el usuario exitosamente");
                    return $this->response->redirect("user");
                }

                foreach ($user->getMessages() as $msg) {
                    $this->flashSession->error($msg);
                }
            }
        }

        $this->view->setVar("user", $user);
    }
	
	public function editprofileAction()
	{
		$user = $this->user;

        $form = new UserForm($user, $this->user);

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $user);
            $user->updated = time();

            if ($form->isValid() && $user->save()) {
                $this->flashSession->success("Se ha editado el usuario exitosamente");
                return $this->response->redirect("user/editprofile");
            }

            foreach ($user->getMessages() as $msg) {
                $this->flashSession->error($msg);
            }
        }

        $this->view->UserForm = $form;
        $this->view->setVar("user", $user);
	}		
			
}