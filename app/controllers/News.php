<?php

class News extends Controller
{

    public $data  = [];
    public function index()
    {
        $this->data['new_title'] = "Tin tức thời sự 1";
        $this->data['new_content'] = "Tin tức thời sự 2 <script>alert('quangcntt')</script>";
        $this->data['new_author'] = "quang";
        $this->data['page_title'] = 'test tieu de';
        $this->render('news/list', $this->data);
    }
}
