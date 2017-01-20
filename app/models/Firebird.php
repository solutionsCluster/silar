<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;
/**
 * La clase Modelbase hereda las funciones:
 * beforeUpdate -> Se ejecuta antes de actualizar un objeto y asigna un valor, en este caso un timestamp para el campo updateon
 * beforeCreate -> Se ejecuta antes de crear un objeto y asigna dos valores, en este caso los respectivo timestamp para createdon y updateon
 * $this->useDynamicUpdate(true); -> Hace que en caso de una edición, solo se actualicen los campos que presentan cambios 
 */
class Firebird extends ModelBase
{
    public $idAccount;
	
    public function initialize()
    {
		$this->hasMany("idFirebird", "Account", "idFirebird");
    }
    
    public function validation()
    {
        $this->validate(new PresenceOf(
            array(
                "field"   => "version",
                "message" => "Debe ingresar una versión"
            )
        ));

        $this->validate(new PresenceOf(
            array(
                "field"   => "port",
                "message" => "Debe ingresar un puerto"
            )
        ));
        
        if ($this->validationHasFailed() == true) {
			return false;
        }
    }       
}   