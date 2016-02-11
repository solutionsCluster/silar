<?php

class FilterController extends ControllerBase {

    public function getbranchesAction() {
        try {
            $sql = "select sysdet.s AS idBranch, sysdet.nombre_sucursal AS name from sysdet";
            $account = $this->user->account;

            $fconnector = new \Silar\Misc\FireBirdConnector();
            $fconnector->setAccount($account);
            $fconnector->executeQuery($sql);
            $result = $fconnector->getResult();
            
            $obj = new stdClass();
            $obj->id = "all";
            $obj->text = "Todas las sucursales";
            
            $branches = array($obj);
            foreach ($result as $r) {
                $obj = new stdClass();
                $obj->id = $r->IDBRANCH;
                $obj->text = utf8_encode(trim($r->NAME));
                $branches[] = $obj; 
            }
            
            return $this->setJsonResponse($branches, 200);
            
        } catch (Exception $ex) {
            $this->logger->log("Exception while connecting database... {$ex}");
            return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
        }
    }

    public function getlinesAction() {
        try {
            $sql = "select * from linea";
            $account = $this->user->account;

            $fconnector = new \Silar\Misc\FireBirdConnector();
            $fconnector->setAccount($account);
            $fconnector->executeQuery($sql);
            $result = $fconnector->getResult();
            
			$obj = new stdClass();
            $obj->id = "all";
            $obj->text = "Todas las lineas";
            
            $lines = array($obj);
            foreach ($result as $r) {
                $obj = new stdClass();
                $obj->id = trim($r->CODLINEA);
                $obj->text = trim($r->DESCLINEA);
                $lines[] = $obj; 
            }
            
            return $this->setJsonResponse($lines, 200);
            
        } catch (Exception $ex) {
            $this->logger->log("Exception while connecting database... {$ex}");
            return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
        }
    }

    public function getgroupsAction() {
         try {
            $sql = "select * from grupo";
            $account = $this->user->account;

            $fconnector = new \Silar\Misc\FireBirdConnector();
            $fconnector->setAccount($account);
            $fconnector->executeQuery($sql);
            $result = $fconnector->getResult();
            
            $obj = new stdClass();
            $obj->id = "all";
            $obj->text = "Todos los grupos";
            
            $groups = array($obj);
            foreach ($result as $r) {
                $obj = new stdClass();
                $obj->id = trim($r->CODGRUPO);
                $obj->text = trim($r->DESCGRUPO);
                $groups[] = $obj; 
            }
            
            return $this->setJsonResponse($groups, 200);
            
        } catch (Exception $ex) {
            $this->logger->log("Exception while connecting database... {$ex}");
            return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
        }
    }
    
    public function getbrandsAction() {
        try {
            $sql = "select marcas.codmarca, marcas.descmarca from marcas";
            $account = $this->user->account;

            $fconnector = new \Silar\Misc\FireBirdConnector();
            $fconnector->setAccount($account);
            $fconnector->executeQuery($sql);
            $result = $fconnector->getResult();
            
            $obj = new stdClass();
            $obj->id = "TODAS";
            $obj->text = "Todas las marcas";
            
            $brands = array($obj);
            foreach ($result as $r) {
                $obj = new stdClass();
                $obj->id = trim($r->CODMARCA);
                $obj->text = trim($r->DESCMARCA);
                $brands[] = $obj; 
            }
            
            return $this->setJsonResponse($brands, 200);
            
        } catch (Exception $ex) {
            $this->logger->log("Exception while connecting database... {$ex}");
            return $this->setJsonResponse(array('message' => 'Error interno, por favor contacte al administrador'), 500);
        }
    }

    public function getmonthsAction() {
        $months = array();
        $r = 1;
        for ($g = 1; $g < 13; $g++) {
            $obj = new stdClass();
            $obj->id = $r;
            $obj->text = "{$r}";
            $months[] = $obj;
            $r++;
        }

        return $this->setJsonResponse($months, 200);
    }

    public function getdaysAction() {
        $days = array();
        $x = 1;
        for ($f = 1; $f < 32; $f++) {
            $obj = new stdClass();
            $obj->id = $x;
            $obj->text = "{$x}";
            $days[] = $obj;
            $x++;
        }

        return $this->setJsonResponse($days, 200);
    }

    public function getyearsAction() {
        $years = array();
        $j = 1980;
        for ($i = 0; $i < 101; $i++) {
            $obj = new stdClass();
            $obj->id = $j;
            $obj->text = "{$j}";
            $years[] = $obj;
            $j++;
        }

        return $this->setJsonResponse($years, 200);
    }

}
