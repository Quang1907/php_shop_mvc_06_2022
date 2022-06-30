<?php

/**
 * Base Model
 */
class Model extends Database
{
    protected $db;
    public function  __construct()
    {
        $this->db = new  Database();
    }
}
