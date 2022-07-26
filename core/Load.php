<?php

class Load
{
    static public function model($model)
    {
        // check file ton tai
        if (file_exists(_DIR_ROOT . '/app/models/' . $model . '.php')) {
            require_once _DIR_ROOT . '/app/models/' . $model . '.php';
            // check class ton tai
            if (class_exists($model)) {
                $model = new $model();
                return $model;
            }
        }
        return false;
    }

    public static function view($view, $data = [])
    {
        extract($data); //  đổi key của mảng thành biến
        if (file_exists(_DIR_ROOT . '/app/views/' . $view . '.php')) {
            require_once _DIR_ROOT . '/app/views/' . $view . '.php';
        } else {
            echo 'khong tim thay view';
        }
    }
}
