<?php

namespace Silar\Misc;

$path = \Phalcon\DI\FactoryDefault::getDefault()->get('path');
require_once "{$path->path}app/library/phpexcel/PHPExcel.php";

class PHPExcelConnector {

    public $data;
    public $logger;
    public $account;
    public $report;
    public $reportData;
    public $path;
    public $filter;
    public $phpExcelObj;

    public function __construct() {
        $this->logger = \Phalcon\DI::getDefault()->get('logger');
        $this->path = \Phalcon\DI::getDefault()->get('path');
    }

    public function setAccount(\Account $account) {
        $this->account = $account;
    }

    public function setReport($report) {
        $this->report = $report;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setFilter($filter) {
        $this->filter = $filter;
    }

    public function createReport() {
        switch ($this->report->code) {
            case 'RPT-001':
                $this->createRTP001Report();
                break;

            case 'RS-003':
                $this->createRS003Report();
                break;

            case 'RS-004':
                $this->createRS004Report();
                break;

            case 'RS-005':
                $this->createRS005Report();
                break;

            case 'RS-006':
                $this->createRS006Report();
                break;

            case 'RS-007':
                $this->createRS007Report();
                break;
	
            case 'RP-001':
                $this->createRP001Report();
                break;
			
			case 'RI-001':
                $this->createRI001Report();
                break;
			
			case 'RI-002':
                $this->createRI002Report();
                break;
			
			case 'RI-003':
                $this->createRI003Report();
                break;
			
			case 'RI-004':
                $this->createRI004Report();
                break;
			
			case 'RI-005':
                $this->createRI005Report();
                break;

            default:
                break;
        }
    }

    private function createRTP001Report() {
        $this->createExcelObject();

        $header = array(
            array('key' => 'A1', 'name' => 'MES'),
            array('key' => 'B1', 'name' => "NOMBRE SUCURSAL"),
            array('key' => 'C1', 'name' => "CÓDIGO LINEA"),
            array('key' => 'D1', 'name' => "NOMBRE LINEA"),
            array('key' => 'E1', 'name' => "VALOR VENTA"),
        );

        $this->createExcelHeader($header);
		
		$month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $row = 2;
		
		$this->logger->log(print_r($this->data, true));
		
        foreach ($this->data as $data) {
            $array = array(
                $month[$data->MES-1],
				utf8_encode(trim($data->NOMBRE_SUCURSAL)),
                $data->CODLINEA,
                $data->DESCLINEA,
                round($data->SUM)
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
        }

        $this->styleExcelHeader('A1:E1');

        $array = array(
            array('key' => 'A', 'size' => 15),
            array('key' => 'B', 'size' => 40),
            array('key' => 'C', 'size' => 15),
            array('key' => 'D', 'size' => 30),
            array('key' => 'E', 'size' => 30),
        );

        $this->setColumnDimesion($array);
        $this->formatUSDNumbers("E2:E{$row}");
        $this->createExcelFilter("D1:D{$row}");

        $this->createExcelFile();
    }

    private function createRS003Report() {
        $this->createExcelObject();

        $header = array(
            array('key' => 'A1', 'name' => 'FECHA'),
            array('key' => 'B1', 'name' => "SUBTOTAL DIARIO"),
            array('key' => 'C1', 'name' => "SUBTOTAL DIARIO ACUMULADO"),
        );

        $this->createExcelHeader($header);

        $row = 2;
        for ($i = 1; $i < count($this->data[0]) + 1; $i++) {
            $fecha = "{$i}/{$this->filter['title']}";
            $daily = round($this->data[0][$i]);
            $acum = round($this->data[1][$i]);
            $array = array($fecha, $daily, $acum);

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
        }

        $this->styleExcelHeader('A1:C1');

        $array = array(
            array('key' => 'A', 'size' => 16),
            array('key' => 'B', 'size' => 20),
            array('key' => 'C', 'size' => 36),
        );

        $this->setColumnDimesion($array);
        $this->formatUSDNumbers("B2:B{$row}");
        $this->formatUSDNumbers("C2:C{$row}");

        $this->createExcelFile();
    }

    private function createRS004Report() {
        $this->createExcelObject();

        $header = array(
            array('key' => 'A1', 'name' => 'MES'),
            array('key' => 'B1', 'name' => "SUBTOTAL POR MES ({$this->filter['year1']})"),
            array('key' => 'C1', 'name' => "SUBTOTAL POR MES ({$this->filter['year2']})"),
            array('key' => 'D1', 'name' => "SUBTOTAL POR MES ACUMULADO ({$this->filter['year1']})"),
            array('key' => 'E1', 'name' => "SUBTOTAL POR MES ACUMULADO ({$this->filter['year2']})"),
        );

        $this->createExcelHeader($header);

        $row = 2;

        $mons = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
		
		for ($i = 1; $i < count($this->data[0][$this->filter['year1']]) + 1; $i++) {
            $mes = $mons[$i];
            $sub1 = round($this->data[0][$this->filter['year1']][$i]);
            $sub2 = round($this->data[0][$this->filter['year2']][$i]);
            $acum1 = round($this->data[1][$this->filter['year1']][$i]);
            $acum2 = round($this->data[1][$this->filter['year2']][$i]);

            $array = array($mes, $sub1, $sub2, $acum1, $acum2);

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
        }

        $this->styleExcelHeader("A1:E1");

        $array = array(
            array('key' => 'A', 'size' => 16),
            array('key' => 'B', 'size' => 30),
            array('key' => 'C', 'size' => 40),
            array('key' => 'D', 'size' => 40),
            array('key' => 'E', 'size' => 40),
        );

        $this->setColumnDimesion($array);

        $this->formatUSDNumbers("B2:B{$row}");
        $this->formatUSDNumbers("C2:C{$row}");
        $this->formatUSDNumbers("D2:D{$row}");
        $this->formatUSDNumbers("E2:E{$row}");

        $this->createExcelFile();
    }

    private function createRS005Report() {
        $this->createExcelObject();

        $header = array(
            array('key' => 'A1', 'name' => 'FECHA'),
            array('key' => 'B1', 'name' => 'CANTIDAD'),
            array('key' => 'C1', 'name' => 'PRECIO PRODUCTO'),
            array('key' => 'D1', 'name' => 'COSTO'),
            array('key' => 'E1', 'name' => 'VALOR VENTA'),
            array('key' => 'F1', 'name' => 'COSTO VENTA'),
            array('key' => 'G1', 'name' => 'NOMBRE SUCURSAL'),
            array('key' => 'H1', 'name' => 'CÓDIGO MARCA'),
            array('key' => 'I1', 'name' => 'NOMBRE MARCA'),
        );

        $this->createExcelHeader($header);

        $row = 2;
        foreach ($this->data as $data) {
            $array = array(
                $data->FECHA,
                $data->QTYSHIP,
                round($data->PRICE),
                round($data->COST),
                round($data->SUBTRACT),
                round($data->MULTIPLY),
                utf8_encode(trim($data->NOMBRE_SUCURSAL)),
                $data->CODMARCA,
                $data->DESCMARCA,
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
        }

        $this->styleExcelHeader("A1:I1");

        $array = array(
            array('key' => 'A', 'size' => 20),
            array('key' => 'B', 'size' => 10),
            array('key' => 'C', 'size' => 20),
            array('key' => 'D', 'size' => 20),
            array('key' => 'E', 'size' => 20),
            array('key' => 'F', 'size' => 20),
            array('key' => 'G', 'size' => 40),
            array('key' => 'H', 'size' => 25),
            array('key' => 'I', 'size' => 30),
        );

        $this->setColumnDimesion($array);

        $this->formatUSDNumbers("C2:C{$row}");
        $this->formatUSDNumbers("D2:D{$row}");
        $this->formatUSDNumbers("E2:E{$row}");
        $this->formatUSDNumbers("F2:F{$row}");

        $this->createExcelFilter("I1:I{$row}");

        $this->createExcelFile();
    }

    private function createRS006Report() {
        $this->createExcelObject();

        $header = array(
            array('key' => 'A1', 'name' => 'MES'),
            array('key' => 'B1', 'name' => 'NOMBRE SUCURSAL'),
            array('key' => 'C1', 'name' => 'CÓDIGO LINEA'),
            array('key' => 'D1', 'name' => 'NOMBRE LINEA'),
            array('key' => 'E1', 'name' => 'CÓDIGO GRUPO'),
            array('key' => 'F1', 'name' => 'NOMBRE GRUPO'),
            array('key' => 'G1', 'name' => 'TOTAL VENTA')
        );

        $this->createExcelHeader($header);
		$months = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
		
        $row = 2;
        foreach ($this->data as $data) {
            $array = array(
                $months[$data->MES],
                utf8_encode(trim($data->NOMBRE_SUCURSAL)),
				$data->CODLINEA,
                $data->DESCLINEA,
                $data->CODGRUPO,
                $data->DESCGRUPO,
                round($data->SUM)
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
        }

        $this->styleExcelHeader("A1:K1");

        $array = array(
            array('key' => 'A', 'size' => 15),
            array('key' => 'B', 'size' => 35),
            array('key' => 'C', 'size' => 25),
            array('key' => 'D', 'size' => 30),
            array('key' => 'E', 'size' => 25),
            array('key' => 'F', 'size' => 30),
            array('key' => 'G', 'size' => 35),
        );

        $this->setColumnDimesion($array);

        $this->formatUSDNumbers("G2:G{$row}");

        $this->createExcelFilter("F1:F{$row}");

        $this->createExcelFile();
    }

    private function createRS007Report() {
        $this->createExcelObject();

        $header = array(
            array('key' => 'A1', 'name' => 'FECHA'),
            array('key' => 'B1', 'name' => 'CÓDIGO DE VENDEDOR'),
            array('key' => 'C1', 'name' => 'NOMBRE VENDEDOR'),
            array('key' => 'D1', 'name' => 'VALOR VENTA'),
            array('key' => 'E1', 'name' => 'CÓDIGO SUCURSAL'),
            array('key' => 'F1', 'name' => 'NOMBRE SUCURSAL'),
            array('key' => 'G1', 'name' => 'META DE VENTA'),
            array('key' => 'H1', 'name' => 'NO APLICA'),
        );

        $this->createExcelHeader($header);

        $row = 2;
        foreach ($this->data as $data) {
            $array = array(
                $data->FECHA,
                $data->SALESMAN,
                $data->NOMBRE,
                round($data->SUBTOTAL),
                $data->ID_SUCURSAL,
                utf8_encode(trim($data->NOMBRE_SUCURSAL)),
                round($data->CUOTAMINMENSUAL),
                $data->DIVIDE,
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
        }

        $this->styleExcelHeader("A1:H1");

        $array = array(
            array('key' => 'A', 'size' => 20),
            array('key' => 'B', 'size' => 15),
            array('key' => 'C', 'size' => 25),
            array('key' => 'D', 'size' => 25),
            array('key' => 'E', 'size' => 15),
            array('key' => 'F', 'size' => 35),
            array('key' => 'G', 'size' => 25),
            array('key' => 'H', 'size' => 25),
        );

        $this->setColumnDimesion($array);

        $this->formatUSDNumbers("G2:G{$row}");
        $this->formatUSDNumbers("D2:D{$row}");

        $this->createExcelFilter("C1:C{$row}");

        $this->createExcelFile();
    }

	private function createRP001Report() {
		$this->createExcelObject();
		$b2 = ($this->filter['filter'] == 'daily' ? 'CARTERA DIARIA' : 'CARTERA ACUMULADA');
		
        $header = array(
            array('key' => 'A1', 'name' => 'FECHA'),
            array('key' => 'B1', 'name' => $b2),
        );

        $this->createExcelHeader($header);

        $row = 2;
		$i = 1;
        foreach ($this->data as $data) {
            $array = array(
                "{$i}/{$this->filter['month']}/{$this->filter['year']}",
                round($data),
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
            $i++;
        }

        $this->styleExcelHeader("A1:B1");

        $array = array(
            array('key' => 'A', 'size' => 20),
            array('key' => 'B', 'size' => 25),
        );

        $this->setColumnDimesion($array);

        $this->formatUSDNumbers("B1:B{$row}");

        $this->createExcelFile();
	}
	
	private function createRI001Report()
	{
		$this->createExcelObject();
		
        $header = array(
            array('key' => 'A1', 'name' => 'PRODUCTO'),
            array('key' => 'B1', 'name' => 'CANTIDAD'),
        );

        $this->createExcelHeader($header);
		
		$row = 2;
		
		for ($i = 0; $i < count($this->data['products']); $i++) {
			$array = array(
                $this->data['products'][$i],
                $this->data['cant'][$i]
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
		}
		
		$this->styleExcelHeader("A1:B1");

        $array = array(
            array('key' => 'A', 'size' => 50),
            array('key' => 'B', 'size' => 15),
        );

        $this->setColumnDimesion($array);
        $this->createExcelFile();
	}
	
	private function createRI002Report()
	{
		$this->createExcelObject();
		
        $header = array(
            array('key' => 'A1', 'name' => 'PRODUCTO'),
            array('key' => 'B1', 'name' => 'VALOR VENTA'),
        );

        $this->createExcelHeader($header);
		
		$row = 2;
		
		for ($i = 0; $i < count($this->data['products']); $i++) {
			$array = array(
                $this->data['products'][$i],
                $this->data['total'][$i]
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
		}
		
		$this->styleExcelHeader("A1:B1");

        $array = array(
            array('key' => 'A', 'size' => 50),
            array('key' => 'B', 'size' => 15),
        );

        $this->setColumnDimesion($array);
		
		$this->formatUSDNumbers("B1:B{$row}");
		 
        $this->createExcelFile();
	}
	
	private function createRI003Report()
	{
		$this->createExcelObject();
		
        $header = array(
            array('key' => 'A1', 'name' => 'PRODUCTO'),
            array('key' => 'B1', 'name' => '% UTILIDAD'),
        );

        $this->createExcelHeader($header);
		
		$row = 2;
		
		for ($i = 0; $i < count($this->data['products']); $i++) {
			$array = array(
                $this->data['products'][$i],
                $this->data['util'][$i]
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
		}
		
		$this->styleExcelHeader("A1:B1");

        $array = array(
            array('key' => 'A', 'size' => 50),
            array('key' => 'B', 'size' => 15),
        );

        $this->setColumnDimesion($array);
		
//		$this->formatUSDNumbers("B1:B{$row}");
		 
        $this->createExcelFile();
	}
	
	private function createRI004Report()
	{
		$this->createExcelObject();
		
        $header = array(
            array('key' => 'A1', 'name' => 'PRODUCTO'),
            array('key' => 'B1', 'name' => 'UTILIDAD'),
        );

        $this->createExcelHeader($header);
		
		$row = 2;
		
		for ($i = 0; $i < count($this->data['products']); $i++) {
			$array = array(
                $this->data['products'][$i],
                $this->data['util'][$i]
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
		}
		
		$this->styleExcelHeader("A1:B1");

        $array = array(
            array('key' => 'A', 'size' => 50),
            array('key' => 'B', 'size' => 15),
        );

        $this->setColumnDimesion($array);
		
		$this->formatUSDNumbers("B1:B{$row}");
		 
        $this->createExcelFile();
	}
	
	private function createRI005Report() {
        $this->createExcelObject();

        $header = array(
            array('key' => 'A1', 'name' => 'FECHA'),
            array('key' => 'B1', 'name' => 'NIT PROVEEDOR'),
            array('key' => 'C1', 'name' => 'PROVEEDOR'),
            array('key' => 'D1', 'name' => 'CÓDIGO ITEM'),
            array('key' => 'E1', 'name' => 'COSTO ITEM'),
            array('key' => 'F1', 'name' => 'CANTIDAD'),
            array('key' => 'G1', 'name' => 'VALOR DESCUENTO'),
            array('key' => 'H1', 'name' => 'VALOR COMPRA'),
            array('key' => 'I1', 'name' => 'DOCUMENTO COMPRA'),
            array('key' => 'J1', 'name' => 'NÚMERO DE DOCUMENTO'),
            array('key' => 'K1', 'name' => 'SUCURSAL'),
        );

        $this->createExcelHeader($header);

        $row = 2;
        foreach ($this->data as $data) {
            $array = array(
                $data->FECHA,
                $data->ID_N,
                $data->COMPANY,
                $data->ITEM,
                round($data->COST),
                $data->QTY,
                round($data->VALORDCT),
                round($data->VALOR),
                $data->TIPO,
                $data->NUMBER,
                utf8_encode(trim($data->NOMBRE_SUCURSAL)),
            );

            $this->phpExcelObj->getActiveSheet()->fromArray($array, NULL, "A{$row}");
            unset($array);
            $row++;
        }

        $this->styleExcelHeader("A1:K1");

        $array = array(
            array('key' => 'A', 'size' => 20),
            array('key' => 'B', 'size' => 15),
            array('key' => 'C', 'size' => 35),
            array('key' => 'D', 'size' => 15),
            array('key' => 'E', 'size' => 15),
            array('key' => 'F', 'size' => 10),
            array('key' => 'G', 'size' => 20),
            array('key' => 'H', 'size' => 20),
            array('key' => 'I', 'size' => 15),
            array('key' => 'J', 'size' => 15),
            array('key' => 'K', 'size' => 40),
        );

        $this->setColumnDimesion($array);

        $this->formatUSDNumbers("E1:E{$row}");
        $this->formatUSDNumbers("G2:G{$row}");
        $this->formatUSDNumbers("H2:H{$row}");

        $this->createExcelFilter("C1:C{$row}");

        $this->createExcelFile();
    }
	
    private function createExcelObject() {
        // Create new PHPExcel object
        $this->phpExcelObj = new \PHPExcel();
        // Set document properties
        $this->phpExcelObj->getProperties()->setCreator('Silar App')
                ->setLastModifiedBy('Silar App')
                ->setTitle($this->report->name)
                ->setSubject('Ventas por Clasificación')
                ->setDescription($this->report->description)
                ->setKeywords('sales report excel')
                ->setCategory('Report');
    }

    private function createExcelHeader($array) {
        $this->phpExcelObj->setActiveSheetIndex(0);
        foreach ($array as $value) {
            $this->phpExcelObj->getActiveSheet()->setCellValue($value['key'], $value['name']);
        }
    }

    private function styleExcelHeader($fields) {
        $this->phpExcelObj->getActiveSheet()->getStyle($fields)->getFont()->setBold(true);
        $this->phpExcelObj->getActiveSheet()->getStyle($fields)->getAlignment()->setWrapText(TRUE);
        $this->phpExcelObj->getActiveSheet()->getStyle($fields)->getFill()
                ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('AAAAAAAA');

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $this->phpExcelObj->getActiveSheet()->getStyle($fields)->applyFromArray($styleArray);
        $this->phpExcelObj->getActiveSheet()->getStyle($fields)->getFont()->getColor()->setARGB('FFFFFFFF');
    }

    private function setColumnDimesion($array) {
        foreach ($array as $value) {
            $this->phpExcelObj->getActiveSheet()->getColumnDimension($value['key'])->setWidth($value['size']);
        }
    }

    private function formatUSDNumbers($fields) {
        $this->phpExcelObj->getActiveSheet()->getStyle($fields)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
//        $this->phpExcelObj->getActiveSheet()->getStyle($fields)->getNumberFormat()->setFormatCode('@');
    }

    private function createExcelFilter($fields) {
        $this->phpExcelObj->getActiveSheet()->setAutoFilter($fields);
    }

    private function createExcelFile() {
        $this->phpExcelObj->setActiveSheetIndex(0);
        $objWriter = \PHPExcel_IOFactory::createWriter($this->phpExcelObj, 'Excel2007');
        $this->saveReport($objWriter);
    }

    private function saveReport($objWriter) {
        $folder = "{$this->path->path}{$this->path->tmpfolder}{$this->account->idAccount}/";

        if (!\file_exists($folder)) {
            $this->logger->log("Y");
            \mkdir($folder, 0777, true);
        }

        $name = "{$this->account->idAccount}-" . date('d-M-Y-His', time()) . "-" . uniqid() . ".xlsx";
        $folder .= $name;
        $objWriter->save($folder);

        $this->reportData = new \Tmpreport();
        $this->reportData->idAccount = $this->account->idAccount;
        $this->reportData->idReport = $this->report->idReport;
        $this->reportData->name = $name;
        $this->reportData->created = time();

        if (!$this->reportData->save()) {
            foreach ($this->reportData->getMessages() as $message) {
                $this->logger->log("Error while saving tmpreport {$message->getMessage()}");
            }
            throw new \Exception("Error while saving tmpreport...");
        }
    }

    public function getReportData() {
        return $this->reportData;
    }

}
