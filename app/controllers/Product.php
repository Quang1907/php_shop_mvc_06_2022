<?php

class Product extends Controller
{
    public function index()
    {
        echo 'danh sach san pham';
    }

    public function listProduct()
    {
        $product = $this->model('ProductModel');
        $dataProduct = $product->getProductList();

        // render view
        $this->render('products/list', $dataProduct);
    }
    public function detail()
    {
        $this->render('products/detail');
    }
}
