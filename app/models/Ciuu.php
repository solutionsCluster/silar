<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\StringLength;

class Ciuu extends ModelBase
{
	public $idAccount;

	public function initialize()
	{
		$this->hasOne('idAccount', 'Account', 'idAccount');
	}

	public function validation()
    {
    	$this->validate(new Uniqueness(
            array(
                "field"   => "idCiuu",
				"message" => "Ya existe una actividad economica registrada con ese código, por favor valide la información"
            )
        ));

		$this->validate(new PresenceOf(
            array(
                "field"   => "idCiuu",
				"message" => "Debe ingresar un código para identificar la actividad economica"
            )
        ));

        $this->validate(new PresenceOf(
            array(
                "field"   => "description",
				"message" => "Debe ingresar una descripción para la actividad economica"
            )
        ));

        $this->validate(new StringLength(
            array(
                "field" => "description",
                "min" => 15,
                "message" => "La descripción es muy corta, debe tener al menos 15 caracteres"
            )
        ));

		if ($this->validationHasFailed() == true) {
			return false;
        }
    }
}