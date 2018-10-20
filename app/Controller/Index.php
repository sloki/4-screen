<?php
namespace  App\Controller;

use App\Helpers\Auth;
use App\Main\BaseController;

class Index extends BaseController
{
    public function index()
    {
        Auth::isUnauthenticated();

        $this->view->addCss(['css/app.css']);
        $this->view->addJS(['js/app.js']);
        $this->view->render('index/index', [
            'title' => 'Home page'
        ]);
    }
}