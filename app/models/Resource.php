<?php

class Resource extends ModelBase
{
    public $idResource;

    public function initialize()
    {
        $this->hasMany("idResource", "Action", "idResource");
    }
}
