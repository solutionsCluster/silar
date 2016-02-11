<?php
use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Select,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Check;
    

class UserForm extends Form
{
    public function initialize()
    {
        $this->add(new Select('idRole', Role::find(), array(
            'using' => array('idRole', 'name'),
            'class' => 'select2'
        )));
        
        $this->add(new Check('status', array(
            'type' => 'checkbox',
            'class' => 'bootstrap-switch'
        )));
        
        $this->add(new Text('email', array(
            'maxlength' => 100,
            'type' => 'email',
            'required' => 'required',
            'class' => 'form-control'
        )));
         
        $this->add(new Text('userName', array(
            'maxlength' => 40,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

    	$this->add(new Password('password1', array(
            'maxlength' => 50,
            'type' => 'text',
            'required' => 'password',
            'class' => 'form-control'
        )));
        
        $this->add(new Password('password2', array(
            'maxlength' => 50,
            'type' => 'password',
            'required' => 'required',
            'class' => 'form-control'
        )));

        $this->add(new Text('name', array(
            'maxlength' => 40,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

        $this->add(new Text('lastName', array(
            'maxlength' => 40,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

        $this->add(new Text('phone', array(
            'maxlength' => 50,
            'type' => 'text',
            'class' => 'form-control'
        )));       
    }
}
