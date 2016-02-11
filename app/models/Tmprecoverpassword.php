<?php

class Tmprecoverpassword extends ModelBase
{
    public $idUser;
	
    public function initialize()
    {
	$this->belongsTo("idUser", "User", "idUser", array(
            "foreignKey" => true,
        ));
    }
}   