<?php

namespace App\Helpers;

class App
{
    /**
     * Validate input fields
     *
     * @param array $source
     * @param array $inputs
     * @param null  $recordId
     * @return bool
     */
    public static function validateInput(array $source, array $inputs, $recordId = null)
    {
        if (!self::exists()) {
            return false;
        }

        if (!isset($source["csrf_token"]) && !Token::check($source["csrf_token"])) {
            Flash::danger('Cross-site verification failed');

            return false;
        }

        $validate = new Validate($source, $recordId);
        $validation = $validate->check($inputs);
        if (!$validation->passed()) {
            Session::put(Config::get('SESSION_ERRORS'), $validation->errors());

            return false;
        }

        return true;
    }

    public static function exists($source = 'post'): bool
    {
        switch ($source) {
            case 'post':
                return !empty($_POST);
            case 'get':
                return !empty($_GET);
        }

        return false;
    }
}