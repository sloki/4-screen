<?php

namespace App\Controller;

use App\Main\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $this->view->addCss(['css/app.css']);
        $this->view->addJS(['js/app.js']);
        $this->view->render('home/index', [
            'title' => 'Home page'
        ]);
    }
}
