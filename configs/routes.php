<?php
$routes['default_controller'] = 'home';
/**
 * đường dẫn ảo =>  Đường dẫn thật
 */
$routes['san-pham'] = 'product';
$routes['trang-chu'] = 'home';
$routes['tin-tuc/.+-(\d+).html'] = 'news/category/$1';
