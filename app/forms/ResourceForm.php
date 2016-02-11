<?php
use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text;
    

class ResourceForm extends Form
{
    public function initialize()
    { 
        $this->add(new Text('name', array(
            'maxlength' => 40,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));   
    }
}
