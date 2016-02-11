<?php
use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\TextArea;

class CiuuCodeForm extends Form
{
    public function initialize()
    {
    	$this->add(new Text('idCiuu', array(
			'maxlength' => 11,
			'type' => 'text',
			'required' => 'required',
			'class' => 'form-control'
        )));

        $this->add(new TextArea('description', array(
			'maxlength' => 400,
			'required' => 'required',
			'class' => 'form-control'
        )));
    }
}
