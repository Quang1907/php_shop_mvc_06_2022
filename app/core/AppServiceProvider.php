<?php

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $user = $this->db->table('user')->where('id', '=', 3)->first();
        $data['userInfo'] = $user;
        $data['coppyRight'] = "CoppyRight &copy; 2022 by QuangCNTT";
        View::share($data);
    }
}
