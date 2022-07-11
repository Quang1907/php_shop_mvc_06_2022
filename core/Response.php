<?php

class Response
{
    public function redirect($uri = '')
    {
        if (preg_match('~^(http|https)~is', $uri)) {
            echo $url = $uri;
        } else {
            $url = _WEB_ROOT . '/' . $uri;
        }
        header('Location: ' . $url);
        exit();
    }
}
