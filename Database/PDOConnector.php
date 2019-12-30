<?php

class PDOConnector
{
    public function __construct(string $connStr, string $user, string $password){
        return new PDO($connStr, $user, $password);
    }
}