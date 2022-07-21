<?php

class Session
{
    /** 
     * data(key, value) => set session
     * data(key) => get session
     */
    static public function data($key = '', $value = '')
    {
        $sessionKey = self::isInvalid();

        if (!empty($value)) {
            if (!empty($key)) {
                $_SESSION[$sessionKey][$key] = $value; // set session
                return true;
            }
            return false;
        } else {
            if (empty($key)) {
                if (isset($_SESSION[$sessionKey])) {
                    return $_SESSION[$sessionKey];
                }
            } else {
                if (isset($_SESSION[$sessionKey][$key])) {
                    return $_SESSION[$sessionKey][$key]; // get session
                }
            }
        }
    }

    /**
     * delete (key) => xoa session voi key
     * delete => destroy
     */
    static public function delete($key = '')
    {
        $sessionKey = self::isInvalid();

        if (!empty($key)) {
            if (isset($_SESSION[$sessionKey][$key])) {
                unset($_SESSION[$sessionKey][$key]);
                return true;
            }
        } else {
            unset($_SESSION[$sessionKey]);
            return true;
        }
        return false;
    }

    /**
     * flash data
     * set flash data =>  giong nhu set session
     * get flash data => giong nhu get session, xoa session sau khi get
     */

    static public function flash($key = "", $value = "")
    {
        $dataFlash = self::data($key, $value);
        if (empty($value)) {
            self::delete($key);
        }
        return $dataFlash;
    }

    static public function isInvalid()
    {
        global $config;
        if (!empty($config['session'])) {
            $sessionConfig = $config['session'];
            if (!empty($sessionConfig['session_key'])) {
                $sessionKey = $sessionConfig['session_key'];
                return $sessionKey;
            } else {
                self::showErrors('Thieu cấu hình session key. Vui lòng kiểm tra file: configs/session.php');
            }
        } else {
            self::showErrors('Thieu cấu hình session. Vui lòng kiểm tra file: configs/session.php');
        }
    }

    static public function showErrors($message)
    {
        $data = ['message' => $message];
        App::$app->loadError($data, 'Exception');
        die();
    }
}
