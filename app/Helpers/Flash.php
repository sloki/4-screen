<?php

namespace App\Helpers;

class Flash
{
    public static function session($key, $value = '')
    {
        if (Session::exists($key)) {
            $session = Session::get($key);
            Session::delete($key);

            return $session;
        }

        if (!empty($value)) {
            return Session::put($key, $value);
        }

        return null;
    }

    public static function danger($value = '')
    {
        return self::session(Config::get('SESSION_FLASH_DANGER'), $value);
    }

    public static function info($value = '')
    {
        return self::session(Config::get('SESSION_FLASH_INFO'), $value);
    }

    public static function success($value = '')
    {
        return self::session(Config::get('SESSION_FLASH_SUCCESS'), $value);
    }

    public static function warning($value = '')
    {
        return self::session(Config::get('SESSION_FLASH_WARNING'), $value);
    }
}
