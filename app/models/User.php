<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\StringLength;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\Regex;
use Phalcon\Mvc\Model\Validator\Uniqueness;
/**
 * La clase Modelbase hereda las funciones:
 * beforeUpdate -> Se ejecuta antes de actualizar un objeto y asigna un valor, en este caso un timestamp para el campo updateon
 * beforeCreate -> Se ejecuta antes de crear un objeto y asigna dos valores, en este caso los respectivo timestamp para createdon y updateon
 * $this->useDynamicUpdate(true); -> Hace que en caso de una edición, solo se actualicen los campos que presentan cambios 
 */
class User extends ModelBase
{
    public $idAccount;
    public $idRole;
    public $idUser;
	
    public function initialize()
    {
        $this->hasMany("idUser", "Tmprecoverpassword", "idUser");
        
        $this->belongsTo("idAccount", "Account", "idAccount", array(
            "foreignKey" => true,
        ));
        
        $this->belongsTo("idRole", "Role", "idRole", array(
            "foreignKey" => true,
        ));
		
    }
    
    public function validation()
    {
        $this->validate(new PresenceOf(array(
            "field"   => "email",
            "message" => "No ha ingresado una dirección de correo eléctronico, por favor verifique la información"
        )));

        $this->validate(new Email(array(
            "field" => "email",
            "message" => "La direccion de correo electronico no es válida, por favor verifique la información"
        )));

        $this->validate(new Uniqueness(array(
            "field"   => "email",
            "message" => "La dirección de correo electrónico ya se encuentra registrada, por favor verifique la información"
        )));

        $this->validate(new PresenceOf(array(
            "field" => "name",
            "message" => "El campo nombre está vacío, por favor verifique la información"
        )));

        $this->validate(new PresenceOf(array(
            "field" => "lastName",
            "message" => "El campo apellido esta vacío, por favor verifique la información"
        )));

//        $this->validate(new PresenceOf(array(
//            "field" => "pass",
//            "message" => "No ha ingresado una contraseña, (minimo 8 caracteres)"
//        )));
//
//        $this->validate(new StringLength(array(
//            "field" => "pass",
//            "min" => 8,
//            "message" => "La contraseña es muy corta, debe tener al menos 8 caracteres y máximo 40"
//        )));

        $this->validate(new PresenceOf(array(
            "field" => "userName",
            "message" => "No ha ingresado un nombre de usuario, lo necesitará para iniciar sesión"
        )));

        $this->validate(new StringLength(array(
            "field" => "userName",
            "min" => 4,
            "message" => "El nombre de usuario es muy corto, debe tener al menos 4 caracteres"
        )));

        $this->validate(new Regex(array(
             'field' => 'userName',
             'pattern' => '/^[a-z0-9\._-]{4,30}/',
             'message' => 'EL nombre de usuario no debe tener espacios ni caracteres especiales, tampoco letras mayúsculas y debe tener mínimo 4 y máximo 40 caracteres'
         )));

        $this->validate(new Uniqueness(array(
             "field"   => "userName",
             "message" => "*Nombre de usuario inválido, verifique la información"
        )));

        return $this->validationHasFailed() != true;
    }		
}
