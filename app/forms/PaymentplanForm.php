<?php
use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Select,
    Phalcon\Forms\Element\TextArea,
    Phalcon\Forms\Element\Check;

class PaymentplanForm extends Form
{
    public function initialize()
    {
        $this->add(new Text('code', array(
            'maxlength' => 100,
            'required' => 'required',
            'autofocus' => 'autofocus',
            'class' => 'form-control'
        )));

        $this->add(new Text('name', array(
            'maxlength' => 100,
            'required' => 'required',
            'class' => 'form-control'
        )));

    	$this->add(new TextArea('description', array(
            'maxlength' => 400,
            'required' => 'required',
            'class' => 'form-control'
        )));
        
        $this->add(new Check('status', array(
            'type' => 'checkbox',
            'class' => 'bootstrap-switch'
        )));
        
        $this->add(new Select('reports[]', Report::find(), array(
            'using' => array('idReport', 'name'),
            'multiple' => 'multiple',
            'class' => 'select2'
        )));
    }
}
