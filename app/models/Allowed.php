<?php

class Allowed extends ModelBase
{
    public $idRole;
    public $idAction;

    public function initialize()
    {
        $this->belongsTo("idRole", "Role", "idRole", array(
            "foreignKey" => true,
        ));

        $this->belongsTo("idAction", "Action", "idAction", array(
            "foreignKey" => true,
        ));
    }
}
