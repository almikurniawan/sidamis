<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $data['title']  = 'Dashboard';
        $data['grid']  = 'Dashboard';
        $data['search']  = 'Dashboard';
        $data['url_delete']  = 'Dashboard';
        // return view('global/list', $data);
    }
}
