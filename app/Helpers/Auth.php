<?php

namespace App\Helpers;

class Auth
{
    public static function isAuthenticated($redirect = 'login')
    {
        Session::init();
        if (!Session::exists(Config::get('SESSION_USER'))) {
            Session::destroy();
            header('Location: ' . APP_URL . $redirect);
        }
    }

    public static function isUnauthenticated($redirect = '')
    {
        Session::init();
        if (Session::exists(Config::get('SESSION_USER'))) {
            header('Location: ' . APP_URL . $redirect);
        }
    }
}