<?php

namespace Silar\Misc;

class FirebirdSQLCreator {

    public $report;
    public $sql = null;
    public $logger;

    public function __construct() {
        $this->logger = \Phalcon\DI::getDefault()->get('logger');
        $this->path = \Phalcon\DI::getDefault()->get('path');
    }

    public function setReport($report) {
        $this->report = $report;
    }

    public function createSQL($object = false) {
        switch ($this->report->code) {
            case 'RPT-001':
                $this->createRPT001($object);
                break;

            case 'RPT-002':
                $this->createRPT002($object);
                break;

            case 'RS-003':
                $this->createRS003($object);
                break;

            case 'RS-004':
                $this->createRS004($object);
                break;

            case 'RS-005':
                $this->createRS005($object);
                break;
			
            case 'RS-006':
                $this->createRS006($object);
                break;
			
            case 'RS-007':
                $this->createRS007($object);
                break;
			
            case 'RS-008':
                $this->createRS008($object);
                break;
			
			case 'RP-001':
				$this->createRP001($object);
                break;
			
			case 'RI-001':
				$this->createRI001($object);
                break;
			
			case 'RI-002':
				$this->createRI002($object);
                break;
			
			case 'RI-003':
				$this->createRI003($object);
                break;
			
			case 'RI-004':
				$this->createRI004($object);
                break;
			
            default:
                $this->sql = null;
                break;
        }
    }

    private function getBetweenDatesSeparatedByBar($year, $month) 
	{
		$r1 = "{$month}/01/{$year}";
        $time = strtotime("{$r1} +1 month");
        $date = date('m/d/Y', $time);
        $time2 = strtotime("{$date} -1 day");
        $r2 = date('m/d/Y', $time2);
        $between = "BETWEEN '{$r1}' AND '{$r2}'";

        return $between;
    }
    
    private function getBetweenDatesSeparatedByPoints($month, $year) 
	{
        $r1 = '01-' . $month . '-' . $year;
        $time = strtotime("{$r1} +1 month");
        $date = date('d-m-Y', $time);
        $time2 = strtotime("{$date} -1 day");
        $r2 = date('d.m.Y', $time2);
        $r1 = str_replace("-", ".", $r1);
        $between = "BETWEEN '{$r1}' AND '{$r2}'";

        return $between;
    }

    private function createRPT001($object) 
	{
        $r1 = (!$object ? date('Y', time()) : $object['year']);
        $between = "BETWEEN '01.01.{$r1} 00:00' AND '31.12.{$r1} 00:00'";
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.ID_SUCURSAL = '{$object['branch']}'");
		
        $this->sql = "SELECT OE.FECHA, OEDET.QTYSHIP, OEDET.PRICE, OEDET.COST, OEDET.PRICE*OEDET.QTYSHIP, OEDET.COST*OEDET.QTYSHIP,
					(select sysdet.nombre_sucursal from sysdet where oe.id_empresa=sysdet.e and oe.id_sucursal=sysdet.s),
					(select linea.codlinea from linea where item.itemmstr=linea.codlinea),
					(select linea.desclinea from linea where item.itemmstr=linea.codlinea),
					(select grupo.codgrupo from grupo where item.itemmstr=grupo.codlinea and item.grupo=grupo.codgrupo),
					(select grupo.descgrupo from grupo where item.itemmstr=grupo.codlinea and item.grupo=grupo.codgrupo),
					(select subgrupo.codsubgrupo from subgrupo where item.itemmstr=subgrupo.codlinea and item.grupo=subgrupo.codgrupo and item.class=subgrupo.codsubgrupo),
					(select subgrupo.descsubgrupo from subgrupo where item.itemmstr=subgrupo.codlinea and item.grupo=subgrupo.codgrupo and item.class=subgrupo.codsubgrupo),
					(select marcas.codmarca from marcas where item.marca=marcas.codmarca),
					(select marcas.descmarca from marcas where item.marca=marcas.codmarca)
					FROM ITEM ITEM, OE OE, OEDET OEDET
					WHERE (OE.FECHA {$between}) {$branch} AND OEDET.ID_EMPRESA = OE.ID_EMPRESA AND OEDET.ID_SUCURSAL = OE.ID_SUCURSAL AND OEDET.NUMBER = OE.NUMBER AND OEDET.TIPO = OE.TIPO AND ITEM.ITEM = OEDET.ITEM";
    }

    private function createRPT002($object) 
	{
        $between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		$branch = ($object['branch'] == 'all' ? "" : " AND oe.id_sucursal = '{$object['branch']}'");
		$branch2 = ($object['branch'] == 'all' ? "" : " AND carpro.s = '{$object['branch']}'");
		$branch3 = ($object['branch'] == 'all' ? "" : " AND gl.s = '{$object['branch']}'");
		
		$ventas = "SELECT SUM ((oedet.price * oedet.qtyship)-oedet.totaldct) AS SALES
					FROM oe, oedet, sysdet 
					WHERE oe.tipo=oedet.tipo 
						AND oe.number=oedet.number 
						AND oe.id_empresa=oedet.id_empresa 
						AND oe.id_sucursal=oedet.id_sucursal 
						AND oe.fecha {$between} 
						AND oe.id_sucursal=sysdet.s {$branch}
					GROUP BY OE.id_sucursal";
						
		$utilv = "SELECT SUM ((oedet.price * oedet.qtyship)-oedet.totaldct) - sum(oedet.cost * oedet.qtyship) AS UTILV
					FROM oe, oedet, sysdet  
					WHERE oe.tipo=oedet.tipo 
						AND oe.number=oedet.number 
						AND oe.id_empresa=oedet.id_empresa 
						AND oe.id_sucursal=oedet.id_sucursal 
						AND oe.fecha {$between} {$branch}	
					GROUP BY OE.id_sucursal";
						
		$util = "SELECT ((sum ((oedet.price * oedet.qtyship)-oedet.totaldct))/(SUM ((oedet.price * oedet.qtyship)-oedet.totaldct) - sum(oedet.cost * oedet.qtyship))) AS UTIL
					FROM oe, oedet, sysdet  
					WHERE oe.tipo=oedet.tipo 
						AND oe.number=oedet.number 
						AND oe.id_empresa=oedet.id_empresa 
						AND oe.id_sucursal=oedet.id_sucursal 
						AND oe.fecha {$between} {$branch}	
					GROUP BY OE.id_sucursal";
						
		$cxc = "SELECT SUM (carpro.saldo) AS CXC
				FROM carpro, acct
				WHERE carpro.acct=acct.acct 
					AND acct.tpoaplccion='CC'
					AND carpro.fecha {$between} {$branch2}
				GROUP BY carpro.s";
						
		$cxp = "SELECT SUM (carpro.saldo) AS CXP
				FROM carpro, acct
				WHERE carpro.acct=acct.acct 
					AND acct.tpoaplccion='CP'
					AND carpro.fecha {$between} {$branch2}
				GROUP BY carpro.s";
					
		$caja = "SELECT SUM (gl.debit-gl.credit) AS CAJA
				FROM gl, acct 
				WHERE gl.acct=acct.acct 
					AND acct.tpoaplccion='CA'
					AND gl.fecha {$between} {$branch3}
				GROUP BY gl.s";
					
		$banco = "SELECT SUM (gl.debit-gl.credit) AS BANCO
				FROM gl, acct 
				WHERE gl.acct=acct.acct 
					AND acct.tpoaplccion='BA'
					AND gl.fecha {$between} {$branch3}
				GROUP BY gl.s";
					
		$saldo = "SELECT SUM (gl.debit-gl.credit) AS SALDO
				FROM gl, acct
				WHERE gl.acct=acct.acct 
					AND gl.acct>=14000000 
					AND gl.acct<=14999999
					AND gl.fecha {$between} {$branch3}
				GROUP BY gl.s";
		
		$gastos = "SELECT SUM (gl.debit-gl.credit) AS GASTOS 
				FROM gl, acct 
				WHERE gl.acct=acct.acct 
					AND gl.acct>=50000000 
					AND gl.acct<=59999999 
					AND gl.fecha {$between} {$branch3}
				GROUP BY gl.s";
					
		$this->sql = array(
			'ventas' => $ventas,
			'utilv' => $utilv,
			'util' => $util,
			'cxc' => $cxc,
			'cxp' => $cxp,
			'caja' => $caja,
			'banco' => $banco,
			'saldo' => $saldo,
			'gastos' => $gastos
		);
    }

    private function createRS003($object)
	{
        $between = $this->getBetweenDatesSeparatedByBar($object['year'], $object['month']);
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.id_sucursal = '{$object['branch']}'");
        $this->sql = "SELECT OE.FECHA, OE.subtotal, OE.id_sucursal, sysdet.nombre_sucursal 
					  FROM oe, sysdet 
					  WHERE OE.FECHA {$between}
						AND OE.id_sucursal = SYSDET.s {$branch}";
    }

    private function createRS004($object) 
	{
        $r1 = (!$object ? date('Y', time()) : $object['year1']);
        $r2 = (!$object ? date('Y', time()) : $object['year2']);
        $between = "(OE.FECHA BETWEEN '01/01/{$r1}' AND '12/31/{$r1}') OR (OE.FECHA BETWEEN '01/01/{$r2}' AND '12/31/{$r2}')";
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.id_sucursal = '{$object['branch']}'");
		
        $this->sql = "SELECT OE.FECHA, OE.subtotal, OE.id_sucursal, sysdet.nombre_sucursal 
					  FROM oe, sysdet 
					  WHERE {$between}
						AND OE.id_sucursal = SYSDET.s {$branch}";
    }

    private function createRS005($object) 
	{
        $between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.id_sucursal = '{$object['branch']}'");
		
        $this->sql = "SELECT OE.FECHA, OEDET.QTYSHIP, OEDET.PRICE, OEDET.COST, (OEDET.PRICE*OEDET.QTYSHIP) - OEDET.totaldct, OEDET.COST*OEDET.QTYSHIP, (select sysdet.nombre_sucursal from sysdet where oe.id_empresa=sysdet.e and oe.id_sucursal=sysdet.s), (select marcas.codmarca from marcas where item.marca=marcas.codmarca), (select marcas.descmarca from marcas where item.marca=marcas.codmarca) 
                      FROM ITEM ITEM, OE OE, OEDET OEDET 
                      WHERE (OE.FECHA {$between}) {$branch} AND OEDET.ID_EMPRESA = OE.ID_EMPRESA AND OEDET.ID_SUCURSAL = OE.ID_SUCURSAL AND OEDET.NUMBER = OE.NUMBER AND OEDET.TIPO = OE.TIPO AND ITEM.ITEM = OEDET.ITEM";
    }

	
	private function createRS006($object) 
	{
		$between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.id_sucursal = '{$object['branch']}'");
		$line = ($object['line'] == 'all' ? "" : " linea.codlinea = '{$object['line']}' AND ");
		$group = ($object['group'] == 'all' ? "" : " grupo.codgrupo = '{$object['group']}' AND ");
		
		$this->sql = "SELECT OE.FECHA, OEDET.QTYSHIP, OEDET.PRICE, OEDET.COST, 
							(OEDET.PRICE*OEDET.QTYSHIP)-oedet.totaldct, OEDET.COST*OEDET.QTYSHIP, 
							(select sysdet.nombre_sucursal from sysdet where oe.id_empresa=sysdet.e and oe.id_sucursal=sysdet.s), 
							(select linea.codlinea from linea where {$line} item.itemmstr=linea.codlinea), 
							(select linea.desclinea from linea where {$line} item.itemmstr=linea.codlinea), 
							(select grupo.codgrupo from grupo where {$group} item.itemmstr=grupo.codlinea and item.grupo=grupo.codgrupo), 
							(select grupo.descgrupo from grupo where {$group} item.itemmstr=grupo.codlinea and item.grupo=grupo.codgrupo) 
					 FROM ITEM ITEM, OE OE, OEDET OEDET 
					 WHERE OEDET.ID_EMPRESA = OE.ID_EMPRESA {$branch} 
						 AND OEDET.ID_SUCURSAL = OE.ID_SUCURSAL 
						 AND OEDET.NUMBER = OE.NUMBER 
						 AND OEDET.TIPO = OE.TIPO 
						 AND ITEM.ITEM = OEDET.ITEM
						 AND OE.FECHA {$between}";
	}
	
	private function createRS007($object)
	{
		$between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		$branch = ($object['branch'] == 'all' ? "" : " AND oe.id_sucursal = '{$object['branch']}'");
		$this->sql = "SELECT OE.SALESMAN, OE.FECHA, OE.SUBTOTAL, oe.id_sucursal, sysdet.nombre_sucursal, VENDEDOR.NOMBRE, VENDEDOR.CUOTAMINMENSUAL, OE.subtotal/vendedor.cuotaminmensual 
					  FROM OE OE, VENDEDOR VENDEDOR, sysdet 
					  WHERE VENDEDOR.IDVEND = OE.SALESMAN {$branch} AND OE.FECHA {$between}";
	}

	private function createRS008($object)
	{
		$between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		$branch = ($object['branch'] == 'all' ? "" : " AND sysdet.id_sucursal = '{$object['branch']}'");
		$this->sql = "SELECT CUST.COMPANY, IP.ID_N, IP.FECHA, IPDET.ITEM, IPDET.COST, IPDET.QTY, IPDET.VALORDCT, (ipdet.cost*ipdet.qty)-ipdet.valordct AS VALOR, IP.TIPO, IP.NUMBER, sysdet.nombre_sucursal
					 FROM CUST CUST, IP IP, IPDET IPDET, sysdet
					 WHERE CUST.ID_N = IP.ID_N AND IP.FECHA {$between} {$branch} 
						AND IP.TIPO = IPDET.TIPO 
						AND IP.NUMBER = IPDET.NUMBER 
						AND IP.E = IPDET.E 
						AND IP.S = IPDET.S 
						and ip.s=sysdet.s";
	}
	
	private function createRP001($object)
	{
		$between = $this->getBetweenDatesSeparatedByBar($object['year'], $object['month']);
		$branch = ($object['branch'] == 'all' ? "" : " AND SYSDET.s = '{$object['branch']}'");
		$this->sql = "SELECT carpro.FECHA, SUM(CARPRO.debit - CARPRO.credit), sysdet.nombre_sucursal
					  FROM CARPRO, sysdet, acct
					  WHERE CARPRO.fecha {$between} 
						 {$branch} AND CARPRO.s=SYSDET.s
						 AND carpro.acct=acct.acct 
						 AND acct.tpoaplccion='CC'
					  GROUP BY carpro.FECHA, CARPRO.s, sysdet.nombre_sucursal";
	}
	
	private function createRI001($object)
	{
		$between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.ID_SUCURSAL = '{$object['branch']}'");
		$this->sql = "SELECT FIRST {$object['cant']} COUNT(OEDET.ITEM), ITEM.DESCRIPCION
                      FROM ITEM ITEM, LOC LOC, OE OE, OEDET OEDET
                      WHERE ITEM.ITEM = OEDET.ITEM 
                          AND OE.ID_EMPRESA = OEDET.ID_EMPRESA 
                          AND OE.ID_SUCURSAL = OEDET.ID_SUCURSAL 
                          AND OE.NUMBER = OEDET.NUMBER 
                          AND OE.TIPO = OEDET.TIPO 
                          AND LOC.LOCALIZACION = OEDET.LOCATION
                          AND OE.FECHA {$between} {$branch}
                      GROUP BY OEDET.ITEM, ITEM.DESCRIPCION ORDER BY COUNT(OEDET.ITEM) DESC;";
	}

	private function createRI002($object)
	{
		$between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.ID_SUCURSAL = '{$object['branch']}'");
		$this->sql = "SELECT FIRST {$object['cant']} OEDET.ITEM, ITEM.DESCRIPCION, ((oedet.qtyship*oedet.price)-oedet.totaldct) AS SALE
						FROM ITEM ITEM, LOC LOC, OE OE, OEDET OEDET
						WHERE ITEM.ITEM = OEDET.ITEM 
							AND OE.ID_EMPRESA = OEDET.ID_EMPRESA 
							AND OE.ID_SUCURSAL = OEDET.ID_SUCURSAL 
							AND OE.NUMBER = OEDET.NUMBER 
							AND OE.TIPO = OEDET.TIPO 
							AND LOC.LOCALIZACION = OEDET.LOCATION
							AND OE.FECHA {$between} {$branch}
						GROUP BY OEDET.ITEM, ITEM.DESCRIPCION, SALE ORDER BY SALE DESC";
	}
	
	private function createRI003($object)
	{
		$between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.ID_SUCURSAL = '{$object['branch']}'");
		$this->sql = "SELECT FIRST {$object['cant']} OEDET.ITEM, ITEM.DESCRIPCION, 100-(((oedet.qtyship*oedet.cost)/((oedet.qtyship*oedet.price)-oedet.totaldct))*100) AS UTILITY
						FROM ITEM ITEM, LOC LOC, OE OE, OEDET OEDET
						WHERE ITEM.ITEM = OEDET.ITEM 
							AND OE.ID_EMPRESA = OEDET.ID_EMPRESA 
							AND OE.ID_SUCURSAL = OEDET.ID_SUCURSAL 
							AND OE.NUMBER = OEDET.NUMBER 
							AND OE.TIPO = OEDET.TIPO 
							AND LOC.LOCALIZACION = OEDET.LOCATION
							AND OE.FECHA {$between} {$branch}
						GROUP BY OEDET.ITEM, ITEM.DESCRIPCION, UTILITY ORDER BY UTILITY DESC";
		
	}
	
	private function createRI004($object)
	{
		$between = $this->getBetweenDatesSeparatedByPoints($object['month'], $object['year']);
		$branch = ($object['branch'] == 'all' ? "" : " AND OE.ID_SUCURSAL = '{$object['branch']}'");							
		$this->sql = "SELECT FIRST {$object['cant']} OEDET.ITEM, ITEM.DESCRIPCION, ((oedet.qtyship*oedet.price)-oedet.totaldct)-(oedet.qtyship*oedet.cost) AS UTIL
						FROM ITEM ITEM, LOC LOC, OE OE, OEDET OEDET
						WHERE ITEM.ITEM = OEDET.ITEM 
							AND OE.ID_EMPRESA = OEDET.ID_EMPRESA 
							AND OE.ID_SUCURSAL = OEDET.ID_SUCURSAL 
							AND OE.NUMBER = OEDET.NUMBER 
							AND OE.TIPO = OEDET.TIPO 
							AND LOC.LOCALIZACION = OEDET.LOCATION
							AND OE.FECHA {$between} {$branch}
						GROUP BY OEDET.ITEM, ITEM.DESCRIPCION, UTIL ORDER BY UTIL DESC";
		
	}

	public function getSQL() {
        return $this->sql;
    }

}
