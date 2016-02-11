<?php
use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Select,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\TextArea,
    Phalcon\Forms\Element\Check;
    

class ReportForm extends Form
{
    public function initialize()
    {
        $this->add(new Check('graphic', array(
            'type' => 'checkbox',
            'class' => 'bootstrap-switch',
        )));
        
        $this->add(new Text('name', array(
            'maxlength' => 200,
            'placeholder' => 'Nombre',
            'required' => 'required',
            'class' => 'form-control'
        )));
        
        $this->add(new TextArea('description', array(
            'maxlength' => 400,
            'placeholder' => 'Descripción',
            'required' => 'required',
            'class' => 'form-control'
        )));
        
        $this->add(new Text('code', array(
            'maxlength' => 100,
            'placeholder' => 'Código del reporte',
            'required' => 'required',
            'class' => 'form-control'
        )));
        
        $this->add(new Text('type', array(
            'maxlength' => 45,
            'placeholder' => 'Tipo de reporte',
            'required' => 'required',
            'class' => 'form-control'
        )));
		
		$this->add(new Select('module', 
			array(
				'sales' => 'Ventas', 
				'inventories' => 'Inventarios',
				'portfolio' => 'Cartera',
				'payables' => 'Cuentas por pagar',
				'accounting' => 'Contabilidad'
			), 
			array(
				'required' => 'required',
				'class' => 'select2'
			)
		));
    }
}
