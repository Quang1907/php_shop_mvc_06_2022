<?php

class ProductModel
{
    public function getProductList()
    {
        return ['san pham 1', 'san pham 2', 'san pham 3'];
    }

    public function getProductDetail($id)
    {
        $data = ['san pham 1', 'san pham 2', 'san pham 3'];
        return $data[$id];
    }
}
