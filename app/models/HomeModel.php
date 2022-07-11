<?php

/*
 * ke thua tu class model 
 */

class HomeModel extends Model
{
    protected $_table = 'product';

    function tableFill()
    {
        return 'product';
    }

    function fieldFill()
    {
        return '';
    }

    function primaryKey()
    {
        return 'id';
    }

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

    public function getListProduct()
    {

        // $result =  $this->db->insert('product', $data);
        // $result = $this->db->table('product')->orderBy('id', 'DESC')->whereLike('name', '%quang%')->limit(3)->get();
        $result = $this->db->table('product as p')->join('user as u', 'p.user_id = u.id')->get();
        return $result;
        // $this->db->where('id', '>', 3);
    }

    public function getDetailProduct($name)
    {
        $this->db->table('product')->whereLike('name', $name)->get();
    }
    public function insertProduct($data)
    {
        $this->db->table('product')->insert($data);
        return $this->db->lastId();
        // $this->db->table('product')->where('id', '=', 194)->update($data);
    }
    public function deleteProduct($id)
    {
        $this->db->table('product')->where('id', '=', $id)->delete();
    }
}
