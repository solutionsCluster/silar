<?php

class Pxa extends ModelBase
{
    public $idAccount;
    public $idPaymentplan;

    public function initialize()
    {
        $this->belongsTo("idAccount", "Account", "idAccount", array(
            "foreignKey" => true,
        ));
        
        $this->belongsTo("idPaymentplan", "Paymentplan", "idPaymentplan", array(
            "foreignKey" => true,
        ));
    }
}