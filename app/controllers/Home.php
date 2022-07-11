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
        $this->product->all();
        echo '<pre>';
        $data = $this->product->getListProduct();
        // $data = $this->product->getDetailProduct('%quang%');
        // var_dump($data);

        // $data = $this->product->first();
        // $data = $this->product->find(105);
        // print_r($data);
        // $data = $this->product->getList();
        // $this->model_home->getDetail(1);
        // $data = $this->product->first();
        // var_dump($data);
        $data = [
            'name' => 'QUANGCNTT 194',
            'age' => 24,
            'user_id' => 1
        ];
        // $result = $this->db->table('product')->insert($data);
        // var_dump($result);
        // echo $this->product->insertProduct($data);
        // $this->product->deleteProduct(199);
    }

    public function get_product()
    {
        $this->render('products/add');
        $request = new Request();
        $data = $request->getFields();
        print_r($data);
    }
    public function post_product()
    {
        $this->render('products/add');
        $request = new Request();
        $data = $request->getFields()['name'];
        print_r($data);
        $response = new Response();
        // $response->redirect('');
    }
}
