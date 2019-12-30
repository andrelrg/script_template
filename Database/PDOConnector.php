<?php

namespace Database;

use PDO;

class PDOConnector
{
    public static function connect(string $connStr, string $user, string $password){
        return new PDO($connStr, $user, $password);
    }
}