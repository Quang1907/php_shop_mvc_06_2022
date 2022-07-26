<?php

class AuthMiddleware extends Middlewares
{
    public function handle()
    {
        // echo "<pre>";
        // $data = $this->db->table('user')->get();
        // var_dump($data);

        $home = Load::model('homeModel');
        $data['product_list'] = $home->getListProduct();
        Load::view('products/list', $data);
        // echo "<pre>";
        // var_dump($data);

        // if (Session::data('admin_login') == null) {
        //     $response = new Response();
        //     $response->redirect('trang-chu');
        // }
    }
}
