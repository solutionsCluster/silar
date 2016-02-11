<?php

namespace Silar\Misc;

class UrlManager
{
    protected $urlManager;
    protected $protocol;
    protected $host;
    protected $port;
    protected $urlbase;
    protected $api1;
    protected $urlbaseTrailing;


    public function __construct($config)
    {	
        if (isset($config->urlmanager)) {
            $this->protocol = $config->urlmanager->protocol;
            $this->host = $config->urlmanager->host;
            $this->port = $config->urlmanager->port;
            $this->urlbase = ($config->urlmanager->urlbase != '' ? $config->urlmanager->urlbase . '/' : $config->urlmanager->urlbase);
            $this->api1 = $config->urlmanager->api1;
        }
        else {
            $this->protocol = "http";
            $this->host = "localhost";
            $this->port = 80;
            $this->appbase = "silar";
            $this->api1 = "api";
        }
        
        $this->urlbaseTrailing = $this->urlbase . (($this->urlbase != '') ? '' : '/' );
    }

    protected function getPrefix($full)
    {
        return ($full ? $this->protocol . '://' .$this->host . '/' : '');
    }
	
    /**
     * Returns the url base ex: "silar" and url full ex: "http://localhost/silar"
     * @return type
     */
    public function getBaseUrl($full = false)
    {
        return $this->getPrefix($full) . $this->urlbase;
    }
	
    /**
     * Return full or relative assets url ex: "http://localhost/silar/assets", "silar/assets"
     * @param boolean $full
     * @return URL string
     */
    public function getAppUrlAsset($full = false)
    {
        return $this->getPrefix($full) . $this->urlbaseTrailing . $this->assets;
    }
	
    public function getUrlAsset()
    {
            return $this->assets;
    }

	
    /**
     * Return uri for ember comunication (API1) ex: "silar/api"
     * @return URL string
     */
    public function getAPIUrl1($full = false)
    {
        return $this->getPrefix($full) . $this->urlbaseTrailing . $this->api1;
    }
}
