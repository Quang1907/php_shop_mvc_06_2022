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

require_once 'configs/routes.php';
require_once 'core/Route.php';
require_once 'app/App.php'; // load app
require_once 'core/Controller.php'; // load base controller
