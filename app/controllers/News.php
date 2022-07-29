<?php

class News extends Controller
{

    public $data  = [];
    public function index()
    {
        $this->data['sub_content']['new_title'] = "Tin tức thời sự 1";
        $this->data['sub_content']['new_content'] = "Tin tức thời sự 2 <script>alert('quangcntt')</script>";
        $this->data['sub_content']['new_author'] = "quang";
        $this->data['sub_content']['page_title'] = 'test tieu de';
        $this->data['content'] = 'news/list';
        $this->render('layouts/client_layout', $this->data);
    }
}
