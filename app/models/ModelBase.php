<?php

class ModelBase extends \Phalcon\Mvc\Model
{
	public function initialize()
	{
		$this->useDynamicUpdate(true);
	}

	public function beforeCreate()
    {
        $this->createdon = time();
        $this->updatedon = time();
    }

    public function beforeUpdate()
    {
        $this->updatedon = time();
    }
}
