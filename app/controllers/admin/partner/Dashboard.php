<?php

class Dashboard
{
    public function index()
    {
        echo 'trang dashboard';
    }
    public function detail($id)
    {
        echo 'trang chi tiet-' . $id;
    }
}
