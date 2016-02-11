<?php

class Action extends ModelBase
{
	public $idResource;
	public $idAction;

	public function initialize()
	{
		$this->hasMany("idAction", "Allowed", "idAction");
		$this->belongsTo("idResource", "Resource", "idResource", array(
            "foreignKey" => true,
        ));
	}
}
