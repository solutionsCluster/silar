<?php

class Pxr extends ModelBase
{
    public $idReport;
    public $idPaymentplan;

    public function initialize()
    {
        $this->belongsTo("idReport", "Report", "idReport", array(
            "foreignKey" => true,
        ));
        
        $this->belongsTo("idPaymentplan", "Paymentplan", "idPaymentplan", array(
            "foreignKey" => true,
        ));
    }
}