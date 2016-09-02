<?php

namespace Silar\Misc;

class SourceModeler 
{
    public $report;
    public $data;
    public $logger;
    public $filter;
    public $modeled = array();
    public $filtered = array();

    public function __construct() 
    {
        $this->logger = \Phalcon\DI::getDefault()->get('logger');
    }

    public function setReport($report)
    {
        $this->report = $report;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

	public function setFilter($filter)
    {
        $this->filter = $filter;
    }
	
    public function model()
    {  
        switch ($this->report->code) {
            case 'RPT-001':
                $this->modelRTP001();
                break;

            case 'RPT-002':
                $this->modelRTP002();
                break;
            
            case 'RS-003':
                $this->modelRS003();
				break;
			
            case 'RS-004':
                $this->modelRS004();
				break;
			
            case 'RS-005':
                $this->modelRS005();
				break;
			
			case 'RS-006':
                $this->modelRS006();
				break;
			
			case 'RS-007':
                $this->modelRS007();
				break;
			
			case 'RP-001':
                $this->modelRP001();
				break;
			
			case 'RI-001':
                $this->modelRI001();
				break;
			
			case 'RI-002':
                $this->modelRI002();
				break;
			
			case 'RI-003':
                $this->modelRI003();
				break;
			
			case 'RI-004':
                $this->modelRI004();
				break;
			
			case 'RI-005':
                $this->modelRI005();
				break;
			
            default:
                break;
        }
    }

    private function modelRTP001()
    { 
	        $source = array();
		if ($this->filter['download'] == 'false') {
			 foreach($this->data as $data) { 
				$class = \trim($data->DESCLINEA);
				$class = (empty($class) ? "INDEFINIDO" : $class);

				if (!isset($source[$class])) {
					$source[$class]['name'] = $class;
					$source[$class]['data'] = array(0,0,0,0,0,0,0,0,0,0,0,0);
					$source[$class]['data'][$data->MES - 1] += round($data->SUM);
				}
				else {
					$source[$class]['data'][$data->MES - 1] += round($data->SUM);;
				}
			}
			
			foreach($source as $s) {
				$this->modeled[] = $s;
			} 
		}
		else if ($this->filter['download'] == 'true') {
			$this->modeled = $this->data;
		}
    }

    private function modelRTP002()
    {
		$d = new \stdClass();
		
		$d->netSales = 0;
		$d->utilv = 0;
		$d->util = 0;
		$d->cxc = 0;
		$d->cxp = 0;
		$d->caja = 0;
		$d->banco = 0;
		$d->saldo = 0;
		$d->gastos = 0;
	
		foreach ($this->data as $data) { 
			if (isset($data[0]->SALES)) {$netsales = $data[0]->SALES; $d->netSales = number_format($data[0]->SALES);}
			if (isset($data[0]->UTILV)) {$utilv = $data[0]->UTILV; $d->utilv = number_format($data[0]->UTILV);}	
			if (isset($data[0]->CXC)) {$d->cxc = number_format($data[0]->CXC);}
			if (isset($data[0]->CXP)) {$d->cxp = number_format($data[0]->CXP);}
			if (isset($data[0]->CAJA)) {$d->caja = number_format($data[0]->CAJA);}
			if (isset($data[0]->BANCO)) {$d->banco = number_format($data[0]->BANCO);}
			if (isset($data[0]->SALDO)) {$d->saldo = number_format($data[0]->SALDO);}
			if (isset($data[0]->GASTOS)) {$d->gastos = number_format($data[0]->GASTOS);}
		}
        
		$d->util = round((($utilv/$netsales) * 100), 2);
        $this->modeled = $d;
    }

    private function modelRS003()
    {
        $source = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 0,
            15 => 0,
            16 => 0,
            17 => 0,
            18 => 0,
            19 => 0,
            20 => 0,
            21 => 0,
            22 => 0,
            23 => 0,
            24 => 0,
            25 => 0,
            26 => 0,
            27 => 0,
            28 => 0,
            29 => 0,
            30 => 0,
            31 => 0,
        );
        
		foreach($this->data as $data) {
			$date = explode('-', $data->FECHA);
			$d = explode(' ', $date[2]);
			$day = ltrim($d[0], '0');
			$source[$day] += round($data->TOTAL);
		}
			
		$new_source = array();
		
		if (isset($this->filter['filter'])) {
			if ($this->filter['filter'] == 'accumulated') {
				for ($i = 1; $i < count($source) + 1; $i++) {
					if ($i == 1) {
						$new_source[$i] = $source[$i];
					}
					else {
						$new_source[$i] = $source[$i] + $new_source[$i-1];
					}
				}
				
				if ($this->filter['download'] == 'true') {
					$source1 = $source;
					$source2 = $new_source;
				}
				else {
					unset($source);
					$source = $new_source;
					unset($new_source);
				}
			}
		}
		
		if ($this->filter['download'] == 'true') {
			$this->modeled[0] = $source1;
			$this->modeled[1] = $source2;
		}
		else {
			$this->modeled = $source;
		}
    }
    
	private function modelRS004()
	{
		$source = array(
			$this->filter['year1'] => array(
				1 => 0,
				2 => 0,
				3 => 0,
				4 => 0,
				5 => 0,
				6 => 0,
				7 => 0,
				8 => 0,
				9 => 0,
				10 => 0,
				11 => 0,
				12 => 0
			),
			$this->filter['year2'] => array(
				1 => 0,
				2 => 0,
				3 => 0,
				4 => 0,
				5 => 0,
				6 => 0,
				7 => 0,
				8 => 0,
				9 => 0,
				10 => 0,
				11 => 0,
				12 => 0
			)
            
        );
		
		foreach($this->data as $data) {
			$date = explode('-', $data->FECHA);
			$month = ltrim($date[1], '0');
			$source[$date[0]][$month] += round($data->SUBTOTAL);
		}
			
		$new_source = array();
		
		if (isset($this->filter['filter'])) {
			if ($this->filter['filter'] == 'accumulated') {
				for ($i = 1; $i < count($source[$this->filter['year1']]) + 1; $i++) {
					if ($i == 1) {
						$new_source[$this->filter['year1']][$i] = $source[$this->filter['year1']][$i];
					}
					else {
						$new_source[$this->filter['year1']][$i] = $source[$this->filter['year1']][$i] + $new_source[$this->filter['year1']][$i-1];
					}
				}
				
				for ($i = 1; $i < count($source[$this->filter['year2']]) + 1; $i++) {
					if ($i == 1) {
						$new_source[$this->filter['year2']][$i] = $source[$this->filter['year2']][$i];
					}
					else {
						$new_source[$this->filter['year2']][$i] = $source[$this->filter['year2']][$i] + $new_source[$this->filter['year2']][$i-1];
					}
				}
				
				if ($this->filter['download'] == 'true') {
					$source1 = $source;
					$source2 = $new_source;
				}
				else {
					unset($source);
					$source = $new_source;
					unset($new_source);
				}
			}
		}
		
        if ($this->filter['download'] == 'true') {
			$this->modeled[0] = $source1;
			$this->modeled[1] = $source2;
		}
		else {
			$this->modeled = $source;
		}
	}
	
	private function modelRS005()
	{
		if ($this->filter['download'] == 'false') {
			$source = array();
			foreach($this->data as $data) {
				$key = trim($data->DESCMARCA);
				$key = (empty($key) ? "INDEFINIDO" : $key);
				if (!isset($source[$key])) {
					$source[$key] = array($key, round($data->SUBTRACT));
				}
				else {
					$val = $source[$key][1] + $data->SUBTRACT;
					$source[$key] = array($key, round($val)); 
				}
			}

			foreach ($source as $value) {
				$this->modeled[] = $value;
			}
		}
		else if ($this->filter['download'] == 'true'){
			$this->modeled = $this->data;
		}
	}
	
	private function modelRS006()
	{
		$source = array();
		if ($this->filter['download'] == 'false') {
//			$this->logger->log(print_r($this->data, true));
			 foreach($this->data as $data) {
				$class = \trim($data->DESCGRUPO);
				$class = (empty($class) ? "INDEFINIDO" : $class);

				if (!isset($source[$class])) {
					$source[$class]['name'] = $class;
					$source[$class]['data'] = array(0,0,0,0,0,0,0,0,0,0,0,0);
					$source[$class]['data'][$data->MES - 1] += round($data->SUM);
				}
				else {
					$source[$class]['data'][$data->MES - 1] += round($data->SUM);;
				}
			}

			foreach($source as $s) {
				$this->modeled[] = $s;
			}
		}
		else if ($this->filter['download'] == 'true') {
			$this->modeled = $this->data;
		}
	}
	
	private function modelRS007()
	{
		if ($this->filter['download'] == 'false') {
			foreach($this->data as $data) {
				if (!isset($this->modeled[$data->SALESMAN])) {
					$object = new \stdClass();
					$object->idSalesman = $data->SALESMAN;
					$object->sales = $data->TOTAL;
					$object->name = trim($data->NOMBRE);
					$object->min = $data->CUOTAMINMENSUAL;
					$this->modeled[$data->SALESMAN] = $object;
				}
				else {
					$obj = $this->modeled[$data->SALESMAN];
					$obj->sales = $obj->sales + $data->SUBTOTAL;
					$this->modeled[$data->SALESMAN] = $obj;
				}
			}
			$this->modeled = array_values($this->modeled);
		}
		else if ($this->filter['download'] == 'true'){
			$this->modeled = $this->data;
		}
	}
	
	private function modelRP001()
	{
		$source = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 0,
            15 => 0,
            16 => 0,
            17 => 0,
            18 => 0,
            19 => 0,
            20 => 0,
            21 => 0,
            22 => 0,
            23 => 0,
            24 => 0,
            25 => 0,
            26 => 0,
            27 => 0,
            28 => 0,
            29 => 0,
            30 => 0,
            31 => 0,
        );
        
		foreach($this->data as $data) {
			$date = explode('-', $data->FECHA);
			$d = explode(' ', $date[2]);
			$day = ltrim($d[0], '0');
			$source[$day] += $data->SUM;
		}
			
		$new_source = array();
		
		if (isset($this->filter['filter'])) {
			if ($this->filter['filter'] == 'accumulated') {
				for ($i = 1; $i < count($source) + 1; $i++) {
					if ($i == 1) {
						$new_source[$i] = $source[$i];
					}
					else {
						$new_source[$i] = $source[$i] + $new_source[$i-1];
					}
				}
				
				unset($source);
				$source = $new_source;
				unset($new_source);
			}
		}
		
        $this->modeled = $source;
	}
	
	private function modelRI001()
	{
		$products = array();
		$cant = array();
		foreach($this->data as $data) {
			if (!in_array($data->DESCRIPCION, $products)) {
				$product = utf8_encode($data->DESCRIPCION);
				$product = trim($product);
				$products[] = $product;
				
				$cant[] = $data->CANT;
			}
		}
		
		$this->modeled = array(
			'products' => $products,
			'cant' => $cant
		);
	}
	
	private function modelRI002()
	{
		$products = array();
		$cant = array();
		foreach($this->data as $data) {
			if (!in_array($data->DESCRIPCION, $products)) {
				$product = utf8_encode($data->DESCRIPCION);
				$product = trim($product);
				$products[] = $product;
				
				$cant[] = round($data->SALE);
			}
		}
		
		$this->modeled = array(
			'products' => $products,
			'total' => $cant
		);
	}
	
	private function modelRI003()
	{
		$products = array();
		$cant = array();
		foreach($this->data as $data) {
			if (!in_array($data->DESCRIPCION, $products)) {
				$product = utf8_encode($data->DESCRIPCION);
				$product = trim($product);
				$products[] = $product;
				
				$cant[] = round($data->UTILITY);
			}
		}
		
		$this->modeled = array(
			'products' => $products,
			'util' => $cant
		);
	}
	
	private function modelRI004()
	{
		$products = array();
		$cant = array();
		foreach($this->data as $data) {
			if (!in_array($data->DESCRIPCION, $products)) {
				$product = utf8_encode($data->DESCRIPCION);
				$product = trim($product);
				$products[] = $product;
				
				$cant[] = round($data->UTIL);
			}
		}
		
		$this->modeled = array(
			'products' => $products,
			'util' => $cant
		);
	}
	
	private function modelRI005()
	{
		$this->modeled = $this->data;
	}
	
    public function getModeledData()
    {
        return $this->modeled;
    }
}
