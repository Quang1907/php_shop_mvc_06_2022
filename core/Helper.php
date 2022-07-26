<?php

$sessionKey = Session::isInvalid();
$errors = Session::flash($sessionKey . '_errors');
$old = Session::flash($sessionKey . '_old');

if (!function_exists('form_error')) {
    function form_error($fielName, $before = "", $after = "")
    {
        global $errors;
        if (!empty($errors) && array_key_exists($fielName, $errors)) {
            return $before . $errors[$fielName] . $after;
        }
        return false;
    }
}


if (!function_exists('old')) {
    function old($fieldName, $default = "")
    {
        global $old;
        if (!empty($old[$fieldName])) {
            return $old[$fieldName];
        }
        return $default;
    }
}
