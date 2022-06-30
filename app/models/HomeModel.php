<?php

/*
 * ke thua tu class model 
 */

class HomeModel extends Model
{
    protected $_table = 'product';

    public function getList()
    {

        $data = [
            'name' => 'quang1',
            'age' => 23,
        ];
        $data = $this->db->insert($this->_table, $data);
        return $data;
    }

    public function getDetail($id)
    {
        $data = [
            'item 1',
            'item 2',
            'item 3',
        ];
        return $data[$id];
    }
}
