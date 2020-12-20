<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\layanan_model;
class layanan extends BaseController
{
    // public function __construct() {
    //
    //      // Mendeklarasikan class ProductModel menggunakan $this->product
    //      $this->layanan = new layanan_model();
    //      /* Catatan:
    //      Apa yang ada di dalam function construct ini nantinya bisa digunakan
    //      pada function di dalam class Product
    //      */
    // }
    public function index()
    {
        $model = new layanan_model();
        $data['layanan']  = $model->get()->getResult();
        return view('frontend/layanan',$data);
    }

    public function detail($layanan_id)
    {
        $model = new layanan_model();
        $data['layanan_detail']  = $model->detail($layanan_id)->getResult();
        $data['layanan_random']  = $model->layanan_random()->getResult();
        return view('frontend/layanan_detail',$data);
    }
}
