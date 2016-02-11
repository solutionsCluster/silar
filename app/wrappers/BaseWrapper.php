<?php

class BaseWrapper 
{
    public $logger;
    public $message;
    
    public function __construct() 
    {
        $this->logger = Phalcon\DI::getDefault()->get('logger');
    }
    
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    public function getMessage()
    {
        return $this->message;
    }
}
