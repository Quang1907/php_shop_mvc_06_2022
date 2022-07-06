<?php

class Database
{
    private $_conn, $db_config;
    use QueryBuilder;

    public function __construct()
    {
        global $db_config;
        $this->db_config = $db_config;
        $this->_conn =  Connection::getInstance(($db_config));
    }

    public function insert($table, $data)
    {
        if (!empty($data)) {
            $fielStr = '';
            $valueStr = '';
            foreach ($data as $key => $value) {
                $fielStr .= $key . ',';
                $valueStr .= "'" . $value . "',";
            }

            $fielStr = rtrim($fielStr, ',');
            $valueStr = rtrim($valueStr, ',');
            $sql = "INSERT INTO  $table($fielStr) VALUES ($valueStr)";
            $status = $this->query($sql);
            if (!$status) return false;
        }
        return true;
    }

    public function update($table, $data, $condition = '')
    {
        if (!empty($data)) {
            $updateStr = '';
            foreach ($data as $key => $value) {
                $updateStr .= "$key='$value',";
            }
            $updateStr = rtrim($updateStr, ',');
            $sql = "UPDATE $table SET $updateStr";
            if (!empty($condition)) {
                $sql = "UPDATE $table SET $updateStr WHERE $condition";
            }
            $status = $this->query($sql);
            if (!$status) return false;
        }
        return true;
    }

    public function delete($table, $condition = ''): bool
    {
        $sql = 'DELETE FROM ' . $table;
        if (!empty($data)) {
            $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
        }
        $status = $this->query($sql);
        if (!$status) return false;
        return true;
    }

    public function query($sql)
    {
        try {
            // $this->_conn =  Connection::getInstance(($this->db_config));
            $statement =  $this->_conn->prepare($sql);
            $statement->execute();
            return $statement;
        } catch (Exception $ex) {
            $mess = $ex->getMessage();
            $data['message'] = $mess;
            App::$app->loadError($data, 'database');
            die();
        }
    }

    public function lastInsertId()
    {
        return  $this->_conn->lastInsertId();
    }
}
