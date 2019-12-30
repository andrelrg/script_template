<?php

namespace Database;

use PDO;

class PDOConnector
{
    public static function connect(string $connStr, string $user, string $password) : PDO{
        return new PDO($connStr, $user, $password, array(PDO::ATTR_PERSISTENT => true));
    }
}