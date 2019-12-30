<?php

// Composer Autoload.
require_once __DIR__ . "/vendor/autoload.php";

//Imports
use Config\Config;

//Getting Config Global variable.
Config::get();

//Here you will complete this switch with directing the name passed in the call to the respective script class.
$script = $argv[1];

switch($script){
    default:
        break;
}