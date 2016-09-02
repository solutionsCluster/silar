<?php

namespace Silar\Misc;

class FirebirdConnector {

    public $logger;
    public $firebird;
    public $path;
    public $account;
    public $connection;
    public $result = array();
    public $rtemp;

    public function __construct() {
        $this->logger = \Phalcon\DI::getDefault()->get('logger');
        $this->firebird = \Phalcon\DI::getDefault()->get('firebird');
        $this->path = \Phalcon\DI::getDefault()->get('path');
    }

    public function setAccount(\Account $account) {
        $this->account = $account;
    }

    public function openConnection() {

        $database = "{$this->firebird->host}/{$this->account->firebird->port}:{$this->path->path}{$this->firebird->dir}{$this->account->idAccount}/{$this->account->idAccount}.FDB"; //die($database);
//$database = "{$this->firebird->host}{$this->path->path}{$this->firebird->dir}{$this->account->idAccount}/{$this->account->idAccount}.FDB";
//print($database); die();
//$database="190.147.164.82/8080:/home/silar/app/databases/{$this->account->idAccount}/{$this->account->idAccount}.FDB";
        $this->logger->log("Database: {$database}");
        $this->logger->log("Username: {$this->firebird->username}");
        $this->logger->log("Password: {$this->firebird->password}");
//die($database);
        $this->connection = \ibase_connect($database, $this->firebird->username, $this->firebird->password);
        if (!$this->connection) {
            throw new \Exception("Acceso denegado");
        }
    }

    public function closeConnection() {
        ibase_close($this->connection);
    }

    public function freeResult() {
        ibase_free_result($this->rtemp);
    }

    public function executeQuery($sql) {
        try { 
            $this->openConnection();

            $this->rtemp = ibase_query($this->connection, $sql);

            while ($row = ibase_fetch_object($this->rtemp)) {
                $this->result[] = $row;
            }

            $this->freeResult();

            $this->closeConnection();
        } catch (Exception $ex) {
            $this->logger->log("Exception while connection with firebird database... {$ex}");
        }
    }

    public function getResult() {
        return $this->result;
    }

}
