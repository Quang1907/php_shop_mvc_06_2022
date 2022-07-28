<?php

class View
{
    public static $dataShare = [];

    public static function share($data)
    {
        self::$dataShare  = $data;
    }
}
