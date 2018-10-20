<?php

namespace App\Helpers;

class User
{
    private static $registerFields
        = [
            'name'            => [
                'required' => true
            ],
            'email'           => [
                'filter'   => 'email',
                'required' => true,
                'unique'   => 'users'
            ],
            'password'        => [
                'min_characters' => 6,
                'required'       => true
            ],
            'password_repeat' => [
                'matches'  => 'password',
                'required' => true
            ],
        ];

    private static $loginFields
        = [
            'email'    => [
                'filter'   => 'email',
                'required' => true
            ],
            'password' => [
                'required' => true
            ]
        ];

    public static function register()
    {
        // Validate the register form inputs.
        if (!App::validateInput($_POST, self::$registerFields)) {
            return false;
        }

        try {
            //new bcrypt hash
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // create user
            $user = new \App\Model\User();
            $userId = $user->createUser([
                'email'    => $_POST['email'],
                'name'     => $_POST['name'],
                'password' => $hash,
            ]);

            Flash::success('Account created!');

            return $userId;
        } catch (\Exception $ex) {
            Flash::danger($ex->getMessage());
        }

        return false;
    }

    public static function login()
    {
        // Validate the login form inputs.
        if (!App::validateInput($_POST, self::$loginFields)) {
            return false;
        }

        // Check if the user exists.
        $email = $_POST['email'];
        if (!$user = \App\Model\User::findUserByEmail($email)) {
            Flash::info('Error logging you in.');

            return false;
        }

        try {
            $data = $user->data();

            // Check if the provided password fits the hashed password in the
            // database.
            $password = $_POST['password'];
            if (!password_verify($password, $data->password)) {
                Flash::info('Error logging you in.');

                return false;
            }

            Session::put(Config::get('SESSION_USER'), $data->id);

            return true;
        } catch (\Exception $ex) {
            Flash::warning($ex->getMessage());
        }

        return false;
    }

    public static function logout()
    {
        // Destroy all data registered to the session.
        Session::destroy();

        return true;
    }
}