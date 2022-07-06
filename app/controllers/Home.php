<?php
class Home extends Controller
{
    public $product;

    public function __construct()
    {
        $this->product = $this->model('HomeModel');
    }

    public function index()
    {
        echo '<pre>';
        $data = $this->product->getListProduct();
        // $data = $this->product->getDetailProduct('%quang%');
        // var_dump($data);

        // $data = $this->product->first();
        // $data = $this->product->find(105);
        print_r($data);
        // $data = $this->product->getList();
        // $this->model_home->getDetail(1);
        // $data = $this->product->first();
        // var_dump($data);

    }
}
