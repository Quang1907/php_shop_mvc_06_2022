<?php

class App
{
    private $__controller, $__action, $__params, $_routes, $_db;

    static public $app;

    function __construct()
    {
        global $routes;
        self::$app = $this;
        $this->_routes = new Route();
        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }
        $this->__action = 'index';
        $this->__params = [];

        /**
         * $this->table()->get();
         */

        if (class_exists('DB')) {
            $dbObject = new DB();
            $this->_db = $dbObject->db;
        }
        // var_dump($this->_db);

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
        $url = $this->_routes->handleRoute($url);

        // middleware
        $this->handleGlobalMiddleware($this->_db);
        $this->handleRouteMiddleware($this->_routes->getUri(), $this->_db);
        //app service Provider
        $this->handleAppServiceProvider($this->_db);

        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);
        $urlCheck = '';
        if (!empty($urlArr)) {
            foreach ($urlArr as $key => $item) {
                $urlCheck .= $item . '/';
                $fileCheck = rtrim($urlCheck, '/');
                $fileArr = explode('/', $fileCheck);
                $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]);
                $fileCheck = implode('/', $fileArr);
                if (!empty($urlArr[$key - 1])) {
                    unset($urlArr[$key - 1]);
                }
                // print_r($fileCheck . '<br>');
                if (file_exists('app/controllers/' .   $fileCheck . '.php')) {
                    $urlCheck = $fileCheck;
                    break;
                }
            }
            $urlArr = array_values($urlArr);
        }

        // Xu ly controller     
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
            unset($urlArr[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        if (empty($urlCheck)) {
            $urlCheck = $this->__controller;
        }

        if (file_exists('app/controllers/' . $urlCheck . '.php')) {
            require_once 'app/controllers/' . $urlCheck . '.php';
            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller();
                if (!empty($this->_db)) {
                    $this->__controller->db = $this->_db;
                }
                unset($urlArr[0]);
            } else {
                $this->loadError();
            }
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
    public function loadError($data = [], $name = "404")
    {
        extract($data);
        require_once 'app/errors/' . $name . ".php";
    }

    public function getCurrentController()
    {
        return $this->__controller;
    }

    public function handleRouteMiddleware($routeKey, $db)
    {
        global $config;
        $routeKey = trim($routeKey);
        // middleware app 
        if (!empty($config['app']['routeMiddleware'])) {
            $routeMiddlewareArr = $config['app']['routeMiddleware'];
            foreach ($routeMiddlewareArr as $key => $middlewareItem) {
                if ($routeKey == trim($key) && file_exists("app/middleware/$middlewareItem.php")) {
                    require_once "app/middleware/$middlewareItem.php";
                    if (class_exists($middlewareItem)) {
                        $middlewareObject = new $middlewareItem();
                        if (!empty($db)) {
                            $middlewareObject->db = $db;
                        }
                        $middlewareObject->handle();
                    }
                }
            }
        }
    }

    public function handleGlobalMiddleware($db)
    {
        global $config;
        if (!empty($config['app']['globalMiddleware'])) {
            $globalMiddlewareArr = $config['app']['globalMiddleware'];
            foreach ($globalMiddlewareArr as $middlewareItem) {
                if (file_exists("app/middleware/$middlewareItem.php")) {
                    require_once "app/middleware/$middlewareItem.php";
                    if (class_exists($middlewareItem)) {
                        $middlewareObject = new $middlewareItem();
                        if (!empty($db)) {
                            $middlewareObject->db = $db;
                        }
                        $middlewareObject->handle();
                    }
                }
            }
        }
    }

    public function handleAppServiceProvider($db)
    {
        global $config;
        if (!empty($config['app']['boot'])) {
            $serviceProviderArr = $config['app']['boot'];
            foreach ($serviceProviderArr as $serviceName) {
                if (file_exists("app/core/$serviceName.php")) {
                    require_once "app/core/$serviceName.php";
                    if (class_exists($serviceName)) {
                        $serviceObject = new $serviceName();
                        if (!empty($db)) {
                            $serviceObject->db = $db;
                        }
                        $serviceObject->boot();
                    }
                }
            }
        }
    }
}
