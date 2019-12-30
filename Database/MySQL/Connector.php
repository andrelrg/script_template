<?php

namespace Database\MySQL;

use Database\ConnectorBase;
use Database\PDOConnector;

class Connector extends ConnectorBase
{
    private $connStr = "mysql:host=%s;port=%s;dbname=%s";
    protected $engine = "mysql";

    public function __construct(string $connName){
        parent::__construct($connName);
        $connStr = sprintf($this->connStr, $this->conn["host"], $this->conn["port"], $this->conn["database"]);
        $this->conn;
        return PDOConnector::connect($connStr,  $this->conn["user"],  $this->conn["pass"]);
    }
}