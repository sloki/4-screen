<?php

namespace App\Main;

use ReflectionClass;
use ReflectionMethod;

class Application
{
    private $controller = CONTROLLER_PATH . 'Index';
    private $action = 'index';
    private $params = [];

    public function __construct()
    {
        try {
            $this->parseUrl();
        } catch (\Exception $ex) {
            http_response_code(404);
            echo $ex->getMessage();
            dd();
        }
    }

    /**
     * Get controller
     *
     * @author Slobodan
     * @throws \Exception
     */
    private function getController()
    {
        if (!empty($this->params[0])) {
            $this->controller = CONTROLLER_PATH . ucfirst(strtolower($this->params[0]));
            unset($this->params[0]);
        }

        if (!class_exists($this->controller)) {
            throw new \Exception('The controller ' . $this->controller . ' does not exist!');
        }

        $this->controller = new $this->controller();
    }

    /**
     * Get action
     *
     * @throws \ReflectionException
     */
    private function getAction()
    {
        if (!empty($this->params[1])) {
            $this->action = $this->params[1];
            unset($this->params[1]);
        }

        // Check to ensure the requested controller method exists
        if (!(new ReflectionClass($this->controller))->hasMethod($this->action)) {
            throw new \Exception('The controller action ' . $this->action . ' does not exist!');
        }

        // Check to ensure the requested controller method is pubic
        if (!(new ReflectionMethod($this->controller, $this->action))->isPublic()) {
            throw new \Exception('The controller action ' . $this->action . ' is not accessible!');
        }
    }

    /**
     * Simple function to parse url
     *
     * @throws \Exception
     * @author Slobodan
     */
    private function parseUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        if (!empty($url)) {
            // parse url
            $this->params = explode("/", filter_var(rtrim($url, "/"), FILTER_SANITIZE_URL));
        }

        if(empty($this->params[0])) {
            unset($this->params[0]);

            $this->params = array_values($this->params);
        }

        $this->getController();
        $this->getAction();

        $this->params = array_values($this->params);
    }

    /**
     * Start application
     *
     * @author Slobodan
     */
    public function run()
    {
        \call_user_func_array([$this->controller, $this->action], $this->params);
    }
}