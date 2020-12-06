<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Home extends BaseController
{
    public function index()
    {
        $data['title']  = 'Dashboard';
        $data['grid']  = 'Dashboard';
        $data['search']  = 'Dashboard';
        $data['url_delete']  = 'Dashboard';
        return view('global/list', $data);
    }
}
