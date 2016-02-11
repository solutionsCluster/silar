<?php

class Role extends ModelBase
{
    public $idRole;
	
    public function initialize()
    {
    	$this->hasMany("idRole", "Allowed", "idRole");
        $this->hasMany("idRole", "User", "idRole");
    }
}
