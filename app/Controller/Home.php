<?php

namespace App\Controller;

use App\Helpers\App;
use App\Helpers\Auth;
use App\Helpers\Config;
use App\Helpers\Session;
use App\Main\BaseController;
use App\Model\User;

class Home extends BaseController
{
    public function index()
    {
        Auth::isAuthenticated('login');

        $userId = Session::get(Config::get('SESSION_USER'));
        $user = User::findUser($userId);
        $userData = $user->data();

        $this->view->addCss(['css/app.css']);
        $this->view->addJS(['js/app.js']);
        $this->view->render('home/index', [
            'title'   => 'Home page',
            'welcome' => 'Welcome, ' . $userData->name . ' !'
        ]);
    }

    public function search()
    {
        Auth::isAuthenticated('login', 'Please login');

        $userId = Session::get(Config::get('SESSION_USER'));
        $user = User::findUser($userId);
        $userData = $user->data();

        $validate = [
            'term' => [
                'required' => true
            ]
        ];
        if (App::validateInput($_POST, $validate)) {
            $data = User::search($_POST['term']);

            $this->view->addCss(['css/app.css']);
            $this->view->addJS(['js/app.js']);
            $this->view->render('home/index', [
                'title'   => 'Home page',
                'welcome' => 'Welcome, ' . $userData->name . ' !',
                'data' => $data
            ]);
        }
    }
}
