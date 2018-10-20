<?php

namespace App\Helpers;

class Config
{
    private static $config = [];

    public static function get($key)
    {
        if (empty(self::$config)) {
            self::$config = require_once APP_CONFIG_FILE;
        }

        if(!empty(self::$config[$key])) {
            return self::$config[$key];
        }

        return null;
    }
}
