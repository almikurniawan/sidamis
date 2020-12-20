<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\home_model;
class Home extends BaseController
{
    public function index()
    {
        $model = new home_model();
        $data['slide']  = $model->get('slide')->getResult();
        $data['layanan']  = $model->get('layanan')->getResult();
        $data['gallery']  = $model->get_gallery()->getResult();
        $data['dinas']  = $model->get('dinas')->getResult();
        return view('frontend/home',$data);
    }
}
