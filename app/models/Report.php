<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\StringLength;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Report extends ModelBase
{
    public $idReport;

    public function initialize()
    {
        $this->hasMany("idReport", "Pxr", "idReport");
        $this->hasMany("idReport", "Tmpreport", "idReport");
    }
    
    public function validation()
    {
        $this->validate(new PresenceOf(
            array(
                "field"   => "name",
                "message" => "Debe ingresar un nombre para el reporte"
            )
        ));
        
        $this->validate(new StringLength(
            array(
                "field" => "name",
                "min" => 4,
                "message" => "El nombre del reporte es muy corto, debe tener al menos 4 caracteres"
            )
        ));
        
        $this->validate(new PresenceOf(
            array(
                "field"   => "description",
                "message" => "Debe ingresar una descripción para el reporte"
            )
        ));
        
        $this->validate(new StringLength(
            array(
                "field" => "description",
                "min" => 10,
                "message" => "la descripción del reporte es muy corta, debe tener al menos 10 caracteres"
            )
        ));
        
        $this->validate(new PresenceOf(
            array(
                "field"   => "code",
                "message" => "Debe ingresar un código para el reporte"
            )
        ));
        
        $this->validate(new StringLength(
            array(
                "field" => "code",
                "min" => 3,
                "message" => "el código del reporte es invalido, debe tener al menos 3 caracteres"
            )
        ));
        
        $this->validate(new Uniqueness(array(
            "field"   => "code",
            "message" => "Ya existe un reporte con el código ingresado, por favor verifique la información"
        )));
        
        $this->validate(new PresenceOf(
            array(
                "field"   => "type",
                "message" => "Debe digitar el tipo de reporte"
            )
        ));
        
        $this->validate(new StringLength(
            array(
                "field" => "type",
                "min" => 4,
                "message" => "el tipo del reporte es invalido, debe tener al menos 4 caracteres"
            )
        ));
        
		 $this->validate(new PresenceOf(
            array(
                "field"   => "module",
                "message" => "Debe seleccionar el módulo al cual pertenece el reporte"
            )
        ));
        
        $this->validate(new StringLength(
            array(
                "field" => "module",
                "min" => 4,
                "message" => "el módulo del reporte es invalido, debe tener al menos 4 caracteres"
            )
        ));
		
        return $this->validationHasFailed() != true;
    }
}