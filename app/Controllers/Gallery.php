<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Gallery_model;
class Gallery extends BaseController
{
    // public function __construct() {
    //
    //      // Mendeklarasikan class ProductModel menggunakan $this->product
    //      $this->gallery = new gallery_model();
    //      /* Catatan:
    //      Apa yang ada di dalam function construct ini nantinya bisa digunakan
    //      pada function di dalam class Product
    //      */
    // }
    public function index()
    {
        $model = new Gallery_model();
        $data['gallery']  = $model->get()->getResult();
        return view('frontend/gallery',$data);
    }

    public function detail($gallery_id)
    {
        $model = new Gallery_model();
        $data['gallery_detail']  = $model->detail($gallery_id)->getResult();
        $data['gallery_random']  = $model->gallery_random()->getResult();
        return view('frontend/gallery_detail',$data);
    }
}
