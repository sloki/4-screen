<?php

namespace App\Main;

use App\Helpers\Session;

class BaseController
{
    protected $view;

    public function __construct()
    {
        // Initialize a session
        Session::init();

        // Create a new instance of the core view class.
        $this->view = new BaseView();
    }
}