<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\StringLength;
use Phalcon\Mvc\Model\Validator\Email;
/**
 * La clase Modelbase hereda las funciones:
 * beforeUpdate -> Se ejecuta antes de actualizar un objeto y asigna un valor, en este caso un timestamp para el campo updateon
 * beforeCreate -> Se ejecuta antes de crear un objeto y asigna dos valores, en este caso los respectivo timestamp para createdon y updateon
 * $this->useDynamicUpdate(true); -> Hace que en caso de una edición, solo se actualicen los campos que presentan cambios 
 */
class Account extends ModelBase
{
    public $idAccount;
    public $idCiuu;
    public $idFirebird;
	
    public function initialize()
    {
		
        $this->hasMany("idAccount", "User", "idAccount");
        $this->hasMany("idAccount", "Assets","idAccount");
        $this->hasMany("idAccount", "Pxa","idAccount");
        $this->hasMany("idAccount", "Tmpreport","idAccount");

        $this->belongsTo("idCiuu", "Ciuu", "idCiuu", array(
            "foreignKey" => true,
        ));
		
		$this->belongsTo("idFirebird", "Firebird", "idFirebird", array(
            "foreignKey" => true,
        ));
    }
    
    public function validation()
    {
        $this->validate(new PresenceOf(
            array(
                "field"   => "name",
                "message" => "Debe ingresar un nombre para la cuenta"
            )
        ));
		
        $this->validate(new StringLength(
            array(
                "field" => "name",
                "min" => 4,
                "message" => "El nombre de la cuenta es muy corto, debe tener al menos 4 caracteres"
            )
        ));

        $this->validate(new PresenceOf(
            array(
                "field"   => "companyName",
                "message" => "Debe ingresar una razón social para la cuenta"
            )
        ));
        
        $this->validate(new StringLength(
            array(
                "field" => "companyName",
                "min" => 4,
                "message" => "La razón social de la cuenta es muy corta, debe tener al menos 4 caracteres"
            )
        ));
		
        $this->validate(new PresenceOf(
            array(
                "field"   => "nit",
                "message" => "Debe ingresar un nit para la cuenta"
            )
        ));
        
        $this->validate(new StringLength(
            array(
                "field" => "nit",
                "min" => 4,
                "message" => "El nit de la cuenta es muy corto, debe tener al menos 4 caracteres"
            )
        ));

        $this->validate(new PresenceOf(
            array(
                "field"   => "city",
                "message" => "Debe ingresar una de ciudad de ubicación"
            )
        ));
        
        $this->validate(new StringLength(
            array(
                "field" => "city",
                "min" => 3,
                "message" => "La ciudad de ubicación es muy corta, debe tener al menos 3 caracteres"
            )
        ));

        $this->validate(new PresenceOf(
            array(
                "field"   => "email",
                "message" => "Debe ingresar un correo corporativo para la cuenta"
            )
        ));
        
        $this->validate(new Email(
            array(
                "field" => "email",
                "message" => "La direccion de correo electronico no es valida por favor verifique la información"
            )
        ));
        
        if ($this->validationHasFailed() == true) {
			return false;
        }
    }       
}   