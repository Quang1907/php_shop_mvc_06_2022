<?php

class Request
{
    private $_rules = [], $_messages = [], $_errors = [];
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    /**
     * 1. method
     * 2. body
     */

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost()
    {
        return $this->getMethod() == 'post' ? true : false;
    }

    public function isGet()
    {
        return $this->getMethod() == 'get' ? true : false;
    }

    public function getFields()
    {
        $dataFields = [];
        if ($this->isGet()) {
            // xu ly lay du lieu voi phuong thuc get
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if ($this->isPost()) {
            // xu ly lay du lieu voi phuong thuc get
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        return $dataFields;
    }

    // set rules
    public function rules($rules = [])
    {
        $this->_rules = $rules;
    }

    // set message
    public function messages($messages = [])
    {
        $this->_messages = $messages;
    }

    // run validate
    public function validate()
    {
        $this->_rules = array_filter($this->_rules);
        $checkValidate = true;
        if (!empty($this->_rules)) {
            $dataFields = $this->getFields();
            foreach ($this->_rules as $fieldName => $ruleItem) {
                $ruleIemsArr = explode('|', $ruleItem);
                foreach ($ruleIemsArr as $rules) {
                    $ruleName = null;
                    $ruleValue = null;
                    $ruleArr = explode(":", $rules);
                    $ruleName = reset($ruleArr);

                    if (count($ruleArr) > 1) {
                        $ruleValue = end($ruleArr);
                    }

                    if ($ruleName == 'required') {
                        if (empty(trim($dataFields[$fieldName]))) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'min') {
                        if (strlen(trim($dataFields[$fieldName])) < $ruleValue) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'max') {
                        if (strlen(trim($dataFields[$fieldName])) > $ruleValue) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'email') {
                        if (!filter_var($dataFields[$fieldName], FILTER_VALIDATE_EMAIL)) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'match') {
                        if (trim($dataFields[$fieldName]) != trim($dataFields[$ruleValue])) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'unique') {
                        $tableName = null;
                        $fieldCheck = null;

                        if (!empty($ruleArr[1])) {
                            $tableName = $ruleArr[1];
                        }

                        if (!empty($ruleArr[2])) {
                            $fieldCheck = $ruleArr[2];
                        }

                        if (!empty($fieldCheck) && !empty($tableName)) {
                            $dataFields[$fieldName] = trim($dataFields[$fieldName]);
                            if (count($ruleArr) == 3) {
                                $sql = "SELECT * FROM $tableName WHERE $fieldCheck = '$dataFields[$fieldName]'";
                            } elseif (count($ruleArr) == 4) {
                                if (!empty($ruleArr[3]) && preg_match('~.+?\=.+?~is', $ruleArr[3])) {
                                    $conditionWhere = $ruleArr[3];
                                    $conditionWhere = str_replace("=", "<>", $conditionWhere);
                                    $sql = "SELECT * FROM $tableName WHERE $fieldCheck = '$dataFields[$fieldName]' AND $conditionWhere";
                                }
                            }
                            $checkExists = $this->db->query($sql)->rowCount();
                            if ($checkExists) {
                                $this->setErrors($fieldName, $ruleName);
                                $checkValidate = false;
                            }
                        }
                    }
                    // callback validate 
                    if (preg_match("~^callback_(.+)~is", $ruleName, $callbackArr)) {
                        if (!empty($callbackArr[1])) {
                            $callbackName = $callbackArr[1];
                            $controller = App::$app->getCurrentController();
                            if (method_exists($controller, $callbackName)) {
                                $checkCallBack = call_user_func_array([$controller, $callbackName], [trim($dataFields[$fieldName])]);
                                if (!$checkCallBack) {
                                    $this->setErrors($fieldName, $ruleName);
                                    $checkValidate = false;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $checkValidate;
    }

    // get errors
    public function errors($fieldName = '')
    {
        if (!empty($this->_errors)) {
            if (empty($fieldName)) {
                $errorsArr = [];
                foreach ($this->_errors as $key => $error) {
                    $errorsArr[$key] = reset($error);
                }
                return $errorsArr;
            }
            return reset($this->_errors);
        }
    }

    public function setErrors($fieldName, $ruleName)
    {
        return $this->_errors[$fieldName][$ruleName] = $this->_messages[$fieldName . '.' . $ruleName];
    }
}
