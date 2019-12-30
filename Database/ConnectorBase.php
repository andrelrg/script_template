<?php


namespace Database;


class ConnectorBase
{
    protected $conn;

    public function __construct(string $connName){
        global $config;
        if (!isset($config["database"][$connName])){
            die(MISSINGCONNECTIONNAME);
        }
        $conn = $config["database"][$connName];
        if ($conn["engine"] != $this->engine){
            die(NOTPROPERENGINE);
        }

        $this->conn = $conn;
    }
}