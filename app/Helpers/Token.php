<?php

namespace App\Helpers;

class Token
{
    public static function generate()
    {
        $maxTime = 86400;
        $tokenSession = Config::get('SESSION_TOKEN');
        $token = Session::get($tokenSession);
        $tokenTimeSession = Config::get('SESSION_TOKEN_TIME');
        $tokenTime = Session::get($tokenTimeSession);
        if ($maxTime + $tokenTime <= time() || empty($token)) {
            Session::put($tokenSession, md5(uniqid(rand(), true)));
            Session::put($tokenTimeSession, time());
        }

        return Session::get($tokenSession);
    }

    public static function check($token): bool
    {
        return $token === Session::get(Config::get('SESSION_TOKEN')) && !empty($token);
    }

}
