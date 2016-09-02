<?php

namespace Silar\Misc;

$path =  \Phalcon\DI\FactoryDefault::getDefault()->get('path');
require_once "{$path->path}app/library/swiftmailer/lib/swift_required.php";

class AdministrativeMessages
{
    protected $message;
    protected $subject;
    protected $from;
    protected $to;
    protected $replyTo;
    protected $logger;
    protected $smtp;
	
    public function __construct() 
    {
        $di =  \Phalcon\DI\FactoryDefault::getDefault();
        $this->logger = $di['logger'];
		$this->smtp = $di['smtpsupport'];
    }

	public function setSmtp($smtp)
	{
		$this->smtp = $smtp;
	}


	public function setSubject($subject)
    {
        $subject = trim($subject); 
        if (empty($subject)) {
            throw new \Exception("Subject is empty");
        }
        
        $this->subject = $subject;
    }
    
    public function setFrom($from)
    {
        $from = trim($from); 
        if (empty($from)) {
            throw new \Exception("From is empty");
        }
        
        $this->from = $from;
    }
    
    public function setTo($to)
    {
		$this->to = $to;
    }
    
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }
    
    public function searchMessage($glue)
    {
        $this->message = \Administrativemessage::findFirst(array(
                            'conditions' => 'type = ?1',
                            'bind' => array(1 => $glue)
                        ));
        
        if (!$this->message) {
            throw new \Exception("Administrative message do not exists");
        }
    }
    
    /**
     * Esta función busca variables en el mensaje(html y texto plano) y las reemplaza por los valores finales
     * @param Array $search
     * @param Array $replace
     */
    public function replaceVariables($search, $replace)
    {
        $this->message->html = \html_entity_decode($this->message->html);
        $this->message->html = \str_replace($search, $replace, $this->message->html);
        $this->message->plaintext = \str_replace($search, $replace,  $this->message->plaintext);
        $this->subject = \str_replace($search, $replace,  $this->subject);
    }
	
    public function sendMessage()
    {
		$transport = \Swift_SmtpTransport::newInstance($this->smtp->smtp, $this->smtp->port3, 'tls')
				->setUsername($this->smtp->user)
				->setPassword($this->smtp->password);

        $mailer = \Swift_Mailer::newInstance($transport);
        
		$message = \Swift_Message::newInstance($this->subject);
        $message->setFrom(array($this->smtp->email => $this->smtp->name));
        $message->setTo($this->to);
		$message->setReplyTo($this->replyTo);
        $message->setBody($this->message->html, 'text/html');
        $message->addPart($this->message->plaintext, 'text/plain');

        $recipients = $mailer->send($message, $failures);

        if ($recipients){
            $this->logger->log("Administrative message {$this->message->type} successfully sent!");
        }
        else {
            throw new \Exception("Error while sending message: {{$this->message->type}} " . print_r($failures, true));
        }
    }
}