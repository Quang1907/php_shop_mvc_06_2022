<?php
define('_DIR_ROOT', str_replace('\\', '/', __DIR__));

// xu ly http root
$url = 'http://';
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = 'https://' . $_SERVER['HTTP_HOST'];
}
$web_root = $url . $_SERVER['HTTP_HOST'];
$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT));
$web_root .= $folder;
define('_WEB_ROOT', $web_root);

/**
 * tu dong require class trong configs
 */

$config_dir = scandir('configs');
if (!empty($config_dir)) {
    foreach ($config_dir as $conf) {
        if ($conf != '.' &&  $conf != '..' && file_exists('configs/' . $conf)) {
            require_once 'configs/' . $conf;
        }
    }
}

// load all service
if (!empty($config['app']['service'])) {
    $allServices = $config['app']['service'];
    if (!empty($allServices)) {
        foreach ($allServices as $serviceName) {
            if (file_exists('app/core/' . $serviceName . ".php")) {
                require_once 'app/core/' . $serviceName . ".php";
            }
        }
    }
}

require_once 'core/Load.php';

// kiem tra config va load vao database;
if (!empty($config['database'])) {
    $db_config = array_filter($config['database']);
    if (!empty($db_config)) {
        require_once 'core/Connection.php';
        require_once 'core/QueryBuilder.php';
        require_once 'core/Database.php';
        require_once 'core/DB.php';
        // $conn = Connection::getInstance($db_config);
    }
}

//  middleware
require_once 'core/Middlewares.php';
require_once 'core/Route.php'; // load route class
require_once 'core/Session.php';

// load core helpers
require_once 'core/Helper.php';

// load all helpers
$allHelpers = scandir('app/helpers');

if (!empty($allHelpers)) {
    foreach ($allHelpers as $item) {
        if (file_exists('app/helpers/' . $item) && $item != "." && $item != "..") {
            require_once 'app/helpers/' . $item;
        }
    }
}

require_once 'app/App.php'; // load app
require_once 'core/Model.php'; // load base model
require_once 'core/Controller.php'; // load base controller
require_once 'core/Request.php'; // load request
require_once 'core/Response.php'; // load response