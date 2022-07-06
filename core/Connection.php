<?php

class Connection
{
    private static $instance =  null,  $connect =  null;
    public function __construct($config)
    {
        // ket noi database
        try {
            $dsn = 'mysql:dbname=' . $config['db'] . ';host=' .  $config['host'];
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            $conn =  new PDO($dsn,  $config['user'],  $config['password'], $options);
            self::$connect = $conn;
        } catch (Exception $ex) {
            $mess = $ex->getMessage();
            $data['message'] = $mess;
            App::$app->loadError($data, 'database');
            die();
        }
    }

    public static function getInstance($config)
    {
        if (self::$instance == null) {
            new Connection($config);
            self::$instance = self::$connect;
        }
        return self::$instance;
    }
}
