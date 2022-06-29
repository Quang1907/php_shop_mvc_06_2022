<?php

class Product extends Controller
{

    public $data = [];

    public function index()
    {
        echo 'danh sach san pham';
    }

    public function listProduct()
    {
        $product = $this->model('ProductModel');
        $this->data['sub_content']['product_list'] =  $product->getProductList();
        $this->data['sub_content']['title'] = 'danh sach san pham';
        $this->data['page_title'] = 'list';
        $this->data['content'] = 'products/list';
        $this->render('layouts/client_layout', $this->data);
    }

    public function detail($id = 0)
    {
        $product = $this->model('ProductModel');
        $this->data['sub_content']['info'] = $product->getProductDetail($id);
        $this->data['sub_content']['title'] = 'chi tiet san pham';
        $this->data['page_title'] = 'Detail';
        $this->data['content'] = 'products/detail';
        $this->render('layouts/client_layout', $this->data);
    }
}
