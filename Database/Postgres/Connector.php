<?php

namespace Database\Postgres;

use Database\ConnectorBase;
use Database\PDOConnector;

class Connector extends ConnectorBase
{
    private $connStr = "pgsql:host=%s;port=%s;dbname=%s";
    protected $engine = "pgsql";

    public function __construct(string $connName){
        parent::__construct($connName);
        $this->connStr = sprintf($this->connStr, $this->conn["host"], $this->conn["port"], $this->conn["database"]);
    }

    public function connect(): \PDO{
        return PDOConnector::connect($this->connStr,  $this->conn["user"],  $this->conn["pass"]);
    }
}