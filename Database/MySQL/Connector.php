<?php

namespace Database\MySQL;

use Database\ConnectorBase;
use Database\PDOConnector;
use PDO;

class Connector extends ConnectorBase
{
    private $connStr = "mysql:host=%s;port=%s;dbname=%s";
    protected $engine = "mysql";

    public function __construct(string $connName){
        parent::__construct($connName);
        $this->connStr = sprintf($this->connStr, $this->conn["host"], $this->conn["port"], $this->conn["database"]);
    }

    public function connect(): PDO{
        return PDOConnector::connect($this->connStr,  $this->conn["user"],  $this->conn["pass"]);
    }
}