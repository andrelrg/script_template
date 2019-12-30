<?php

namespace Config;

class Config
{
    public static function get(){
        global $config;
        $str = file_get_contents(dirname(__FILE__).'/config.json');
        $config = json_decode($str, true);
    }
}