<?php

namespace App\Controller;

use App\Helpers\Auth;
use App\Main\BaseController;

class Login extends BaseController
{
    public function index()
    {
        Auth::isUnauthenticated('home');

        $this->view->addCss(['css/app.css']);
        $this->view->addJS(['js/app.js']);
        $this->view->render('login/index', [
            'title' => 'Login page'
        ]);
    }

    public function login()
    {
        Auth::isUnauthenticated('home');

        if (\App\Helpers\User::login()) {
            header('Location: ' . APP_URL . 'home');
            dd();
        }

        header('Location: ' . APP_URL . 'login');
        dd();
    }

    public function logout()
    {
        // Check that the user is authenticated.
        Auth::isAuthenticated();

        if (\App\Helpers\User::logout()) {
            header('Location: ' . APP_URL);
            dd();
        }

        header('Location: ' . APP_URL);
        dd();
    }

}
