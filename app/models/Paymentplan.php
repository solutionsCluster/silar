<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\StringLength;

class Paymentplan extends ModelBase
{
    public $idPaymentplan;

    public function initialize()
    {
        $this->hasMany('idPaymentplan', 'Pxr', 'idPaymentplan');
        $this->hasMany('idPaymentplan', 'Pxa', 'idPaymentplan');
    }

    public function validation()
    {
        $this->validate(new PresenceOf(
            array(
                "field"   => "code",
                "message" => "No ha ingresado un código para el plan de pago, por favor verifique la información"
            )
        ));
	
        $this->validate(new StringLength(
            array(
                "field" => "code",
                "min" => 3,
                "message" => "El código ingresado es invalido, debe tener al menos 3 caracteres"
            )
        ));
        
        $this->validate(new Uniqueness(
                array(
                    "field" => "code",
                    "message" => "Ya existe un plan de pago con el código ingresado, por favor verifique la información"
                )
        ));

        $this->validate(new PresenceOf(
            array(
                "field"   => "description",
                "message" => "Debe ingresar una descripción para el plan de pago"
            )
        ));

        $this->validate(new StringLength(
            array(
                "field" => "description",
                "min" => 15,
                "message" => "La descripción es muy corta, debe tener al menos 15 caracteres"
            )
        ));

        $this->validate(new PresenceOf(
            array(
                "field"   => "name",
                "message" => "Debe ingresar un nombre para el plan de pago"
            )
        ));
		
        $this->validate(new StringLength(
            array(
                "field" => "name",
                "min" => 5,
                "message" => "El nombre del plan de pago, debe tener al menos 5 caracteres"
            )
        ));

        return $this->validationHasFailed() != true;
    }       
}