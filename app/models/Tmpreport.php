<?php

class Tmpreport extends ModelBase
{
	public $idAccount;
	public $idReport;

    public function initialize()
    {
        $this->belongsTo("idAccount", "Account", "idAccount", array(
            "foreignKey" => true,
        ));
		
		$this->belongsTo("idReport", "Report", "idReport", array(
            "foreignKey" => true,
        ));
    }
}