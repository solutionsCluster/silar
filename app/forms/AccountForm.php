<?php
use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Select,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Check;
    

class AccountForm extends Form
{
	public function initialize()
    {
		$this->add(new Select('idCiuu', Ciuu::find(), array(
            'using' => array('idCiuu', 'description'),
            'class' => 'select2 select'
        )));
		
		$this->add(new Select('idFirebird', Firebird::find(), array(
            'using' => array('idFirebird', 'version'),
            'class' => 'select2 select'
        )));

        $this->add(new Check('status', array(
            'type' => 'checkbox',
            'class' => 'bootstrap-switch'
        )));
		
        $this->add(new Check('astatus', array(
            'type' => 'checkbox',
            'class' => 'bootstrap-switch'
        )));

        $this->add(new Text('name', array(
            'maxlength' => 200,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));
		
        $this->add(new Text('aname', array(
            'maxlength' => 200,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

    	$this->add(new Text('nit', array(
            'maxlength' => 50,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control',
            'autofocus' => 'autofocus'
        )));

        $this->add(new Text('companyName', array(
            'maxlength' => 200,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

        $this->add(new Text('city', array(
            'maxlength' => 200,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

        $this->add(new Text('address', array(
            'maxlength' => 200,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

        $this->add(new Text('city', array(
            'maxlength' => 200,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

        $this->add(new Text('phone', array(
            'maxlength' => 45,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));

        $this->add(new Text('fax', array(
            'maxlength' => 45,
            'type' => 'text',
            'class' => 'form-control'
        )));

        $this->add(new Text('email', array(
            'maxlength' => 100,
            'type' => 'text',
            'required' => 'required',
            'class' => 'form-control'
        )));
        
        $this->add(new Select('paymentplans[]', Paymentplan::find(), array(
            'using' => array('idPaymentplan', 'name'),
            'multiple' => 'multiple',
            'class' => 'select2 select'
        )));
		
		$this->add(new Select("database", array(
			'firebird' => 'firebird'
		)));
    }
}