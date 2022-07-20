<?php
class Home extends Controller
{
    public $product, $data;

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

    public function get_user()
    {
        $this->render('user/add');
    }

    public function post_user()
    {
        $request = new Request();
        if ($request->isPost()) {
            $request->rules([
                'fullname' => 'required|min:5|max:30',
                'email' => 'required|email|min:6',
                'password' => 'required|min:3',
                'confirm_password' => 'required|min:3|match:password'
            ]);

            $request->messages([
                'fullname.required' => 'ho ten khong duoc de trong',
                'fullname.min' => 'ho ten khong nho hon 5 ky tu',
                'fullname.max' => 'ho ten phai nho hon 30 ky tu',
                'email.required' => 'email khong duoc de trong',
                'email.email' => 'dinh dang email khong dung',
                'email.min' => 'email khong qua 6 ky tu',
                'password.required' => 'mat khau khong duoc de trong',
                'password.min' => 'mat khau khong nho hon 3 ky tu',
                'confirm_password.required' => 'nhap lai mat khau khong duoc de trong',
                'confirm_password.min' => 'confirm khong nho hon 3 ky tu',
                'confirm_password.match' => 'confirm sai',
            ]);

            $validate = $request->validate();
            if (!$validate) {
                $this->data['errors']  = $request->errors();
                $this->data['msg'] = 'da co loi. vui long kiem tra lai';
                $this->data['old'] = $request->getFields();
            }
            $this->render('user/add', $this->data);
        } else {
            $response  = new Response();
            $response->redirect('home/get_user');
        }
        // var_dump($validate); 
        // print_r($request->errors);

        // echo $request->error('fullname');


        // $data = $request->getFields();
        // $response = new Response();
        // $response->redirect('');
    }
}
