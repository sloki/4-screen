<?php

namespace App\Controller;

use App\Helpers\Auth;
use App\Helpers\User;
use App\Main\BaseController;

class Register extends BaseController
{
    public function index()
    {
        Auth::isUnauthenticated('home');

        $this->view->addCss(['css/app.css']);
        $this->view->addJS(['js/app.js']);
        $this->view->render('register/index', [
            'title' => 'Register page'
        ]);
    }

    public function register()
    {
        Auth::isUnauthenticated('home');

        if (User::register()) {
            header('Location: ' . APP_URL . 'login');
            dd();
        }

        header('Location: ' . APP_URL . 'register');
        dd();
    }

}
