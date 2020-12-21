<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\tentang_model;
class Tentang extends BaseController
{
    // public function __construct() {
    //
    //      // Mendeklarasikan class ProductModel menggunakan $this->product
    //      $this->tentang = new tentang_model();
    //      /* Catatan:
    //      Apa yang ada di dalam function construct ini nantinya bisa digunakan
    //      pada function di dalam class Product
    //      */
    // }
    public function index($tipe)
    {
        $model = new tentang_model();
        $data['tentang']  = $model->get($tipe)->getResult();
        return view('frontend/tentang',$data);
    }

  
}
