<?php

class Request
{
    private $_rules = [], $_messages = [];
    public $errors = [];
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
                    $rulesArr = explode(":", $rules);
                    $ruleName = reset($rulesArr);

                    if (count($rulesArr) > 1) {
                        $ruleValue = end($rulesArr);
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
                }
            }
        }
        return $checkValidate;
    }

    // get errors
    public function errors($fieldName = '')
    {
        if (!empty($this->errors)) {
            if (empty($fieldName)) {
                $errorsArr = [];
                foreach ($this->errors as $key => $error) {
                    $errorsArr[$key] = reset($error);
                }
                return $errorsArr;
            }
            return reset($this->errors);
        }
    }

    public function setErrors($fieldName, $ruleName)
    {
        return $this->errors[$fieldName][$ruleName] = $this->_messages[$fieldName . '.' . $ruleName];
    }
}
