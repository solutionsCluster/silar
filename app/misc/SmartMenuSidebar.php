<?php

namespace Silar\Misc;

class SmartMenuSidebar extends \Phalcon\Mvc\User\Component implements \Iterator
{	
    protected $controller;

    private $_menu = array (
        "Inicio" => array(
            "controller" => array("index"),
            "class" => "",
            "url" => "/",
            "arrow" => "",
            "title" => "Inicio",
            "icon" => "glyphicon glyphicon-home",
            "idChild" => 0,
            "childDisplay" => "display: none;",
            "child" => array()
        ),
        "Reportes" => array(
            "controller" => array("none"),
            "class" => "",
            "url" => "",
            "arrow" => "parent-style parent-arrow-right",
            "title" => "Reportes",
            "icon" => "glyphicon glyphicon-list-alt",
            "idChild" => 1,
            "childDisplay" => "display: none;",
            "child" => array(
                array("controller" => array("inventories"),
                "class" => "",
                "url" => "inventories",
                "title" => "Productos",
                "icon" => ""),
                
                array("controller" => array("sales"),
                "class" => "",
                "url" => "sales",
                "title" => "Ventas",
                "icon" => ""),
				
				array("controller" => array("portfolio"),
                "class" => "",
                "url" => "portfolio",
                "title" => "Cartera",
                "icon" => ""),
            )
        ),
        "Administracion" => array(
            "controller" => array("managment", "account", "user", "security", "imagebank", "paymentplan", "ciuucode", "report"),
            "class" => "",
            "url" => "managment",
            "arrow" => "",
            "title" => "Administración",
            "icon" => "glyphicon glyphicon-wrench",
            "idChild" => 2,
            "childDisplay" => "display: none;",
            "child" => array()
        ),
    );

    public function __construct() 
    {
        $this->controller =  $this->view->getControllerName();
    }


    public function get() 
    {
        return $this;
    }

    public function rewind()
    {
         \reset($this->_menu);
    }

    public function current()
    {
        $obj = new \stdClass();
		
        $curr = \current($this->_menu);

        $obj->title = $curr['title'];
        $obj->icon = $curr['icon'];
        $obj->arrow = $curr['arrow'];
        $obj->url = $curr['url'];
        $obj->idChild = $curr['idChild'];   
        $obj->childDisplay = $curr['childDisplay'];    
        $obj->class = '';
        
        $child = array();
        
        foreach ($curr['child'] as $ch) {
            $object = new \stdClass();
            $object->class = "";
            $object->url = $ch["url"];
            $object->title = $ch["title"];
            $object->icon = $ch["icon"];
            
            if (\in_array($this->controller, $ch['controller'])) {
                $obj->childDisplay = "display: block;";
                $obj->arrow = "parent-style parent-arrow-down";
                $object->class = 'active';
            }
            
            $child[] = $object;
        }
        
        if (\in_array($this->controller, $curr['controller'])) {
            $obj->class = 'active';
        }
	
        $obj->child = $child; 
        
        return $obj;
    }

    public function key()
    {
        return \key($this->_menu);
    }

    public function next()
    {
        $var = \next($this->_menu);
    }

    public function valid()
    {
        $key = \key($this->_menu);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }
}
