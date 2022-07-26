<?php

class Route
{
    private $_keyRoute = null;

    public function handleRoute($url)
    {
        global $routes;
        unset($routes['default_controller']);
        $url = trim($url, '/');
        if (empty($url)) $url = '/';
        $handleUrl = $url;
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (preg_match('~' . $key . '~is', $url)) {
                    $handleUrl = preg_replace('~' . $key . '~is', $value, $url);
                    $this->_keyRoute = $key;
                }
            }
        }
        return $handleUrl;
    }

    public function getUri()
    {
        return $this->_keyRoute;
    }

    public static function getFullUrl()
    {
        $uri = App::$app->getUrl();
        $url = _WEB_ROOT . $uri;
        return $url;
    }
}
