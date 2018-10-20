<?php

namespace App\Helpers;

/**
 * Simple session helper
 *
 * @package App\Helpers
 */
class Session
{
    public static function delete($key): bool
    {
        if (self::exists($key)) {
            unset($_SESSION[$key]);

            return true;
        }

        return false;
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key)
    {
        if (self::exists($key)) {
            return $_SESSION[$key];
        }
    }

    public static function init()
    {
        // If no session exist, start the session.
        if (session_id() === '') {
            session_start();
        }
    }

    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;

        return $value;
    }
}