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
        // $check =  Session::data('username', 'quangcntt');
        // var_dump($check);
        // $sessionData = Session::data(
        //     'username',
        //     [
        //         'name' => 'quangit',
        //         'email' => 'quang@gmail.com'
        //     ]
        // );
        // $sessionData = Session::data(
        //     'password',
        //     23424387
        // );
        // echo '<pre>';
        // Session::flash("msg", "them du lieu thanh cong");
        // $msg = Session::flash("msg");
        // $check =  Session::data();
        // var_dump($check);

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
        // $this->data['errors'] = Session::flash('errors');
        $this->data['msg'] = Session::flash('msg');
        // $this->data['old'] = Session::flash('old');
        $this->render('user/add', $this->data);
    }

    public function post_user()
    {
        $request = new Request();
        $id = 1;
        if ($request->isPost()) {
            $request->rules([
                'fullname' => 'required|min:5|max:30',
                'email' => 'required|email|min:6|unique:user:email',
                'password' => 'required|min:3',
                'confirm_password' => 'required|min:3|match:password',
                'age' => 'required|callback_check_age',
            ]);

            $request->messages([
                'fullname.required' => 'ho ten khong duoc de trong',
                'fullname.min' => 'ho ten khong nho hon 5 ky tu',
                'fullname.max' => 'ho ten phai nho hon 30 ky tu',
                'email.required' => 'email khong duoc de trong',
                'email.email' => 'dinh dang email khong dung',
                'email.min' => 'email khong nho hon 6 ky tu',
                'email.unique' => 'email da ton tai',
                'password.required' => 'mat khau khong duoc de trongx',
                'password.min' => 'mat khau khong nho hon 3 ky tu',
                'confirm_password.required' => 'nhap lai mat khau khong duoc de trong',
                'confirm_password.min' => 'confirm khong nho hon 3 ky tu',
                'confirm_password.match' => 'confirm sai',
                'age.required' => 'tuoi ko duoc de trong',
                'age.callback_check_age' => "tuoi khong duoc nho hon 20"
            ]);

            $validate = $request->validate();
            if (!$validate) {
                // Session::flash('errors', $request->errors());
                Session::flash('msg', 'da co loi. vui long kiem tra lai');
                // Session::flash('old',  $request->getFields());
                // $this->data['errors']  = $request->errors();
                // $this->data['msg'] = 'da co loi. vui long kiem tra lai';
                // $this->data['old'] = $request->getFields();
            }
            // $this->render('user/add', $this->data);
        }
        // else {
        //     $response  = new Response();
        //     $response->redirect('home/get_user');
        // }
        // Session::delete();
        $response  = new Response();
        $response->redirect('home/get_user');

        // var_dump($validate); 
        // print_r($request->errors);

        // echo $request->error('fullname');
        // $data = $request->getFields();
        // $response = new Response();
        // $response->redirect('');
    }

    public function check_age($age)
    {
        return ($age >= 20) ? true : false;
    }
}
