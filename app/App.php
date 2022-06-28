<?php

class App
{
    private $__controller, $__action, $__params;

    function __construct()
    {
        global $route;
        if (!empty($route['default_controller'])) {
            $this->__controller = $route['default_controller'];
        }
        $this->__action = 'index';
        $this->__params = [];
        $this->handleUrl();
    }

    function getUrl()
    {
        $url = '/';
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        }
        return $url;
    }

    public function handleUrl()
    {
        $url = $this->getUrl();
        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);

        // Xu ly controller     
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        if (file_exists('app/controllers/' . $this->__controller . '.php')) {
            require_once 'app/controllers/' . $this->__controller . '.php';
            // kiem tra class $this->__controller ton tai 
            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller();
                unset($urlArr[0]);
            } else {
                $this->loadError();
            }
            // $this->__controller->index();
        } else {
            $this->loadError();
        }

        // xu ly action
        if (!empty($urlArr[1])) {
            $this->__action = $urlArr[1];
            unset($urlArr[1]);
        }

        // xu ly params
        $this->__params = array_values($urlArr);
        // kiem tra method ton tai
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }
    }

    // xu ly loi
    public function loadError($name = "404")
    {
        require_once 'app/errors/' . $name . ".php";
    }
}
