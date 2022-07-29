<?php

class Controller
{
    public $db;

    public function model($model)
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

    public function render($view, $data = [])
    {
        if (!empty(View::$dataShare)) {
            $data = array_merge($data, View::$dataShare);
        }

        extract($data); //  đổi key của mảng thành biến



        $contentView = null;

        if (preg_match("~layouts~", $view)) {
            // ob_start();
            if (file_exists(_DIR_ROOT . '/app/views/' . $view . '.php')) {
                require_once _DIR_ROOT . '/app/views/' . $view . '.php';
            }
            // $contentView = ob_get_contents();
            // ob_end_clean();
        } else {
            if (file_exists(_DIR_ROOT . '/app/views/' . $view . '.php')) {
                $contentView  = file_get_contents(_DIR_ROOT . '/app/views/' . $view . '.php');
            }
            $template = new Template();
            $template->run($contentView, $data);
        }
    }
}
