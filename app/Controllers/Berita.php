<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Berita_model;
class Berita extends BaseController
{
    // public function __construct() {
    //
    //      // Mendeklarasikan class ProductModel menggunakan $this->product
    //      $this->berita = new Berita_model();
    //      /* Catatan:
    //      Apa yang ada di dalam function construct ini nantinya bisa digunakan
    //      pada function di dalam class Product
    //      */
    // }
    public function index()
    {
        $model = new Berita_model();
        $data = [
            'berita' => $model->asObject()->paginate(10,'btberita'),
            'pager' => $model->pager
        ];
        // $data['berita']  = $model->get()->getResult();
        return view('frontend/berita',$data);
    }

    public function detail($berita_id)
    {
        $model = new Berita_model();
        $data['berita_detail']  = $model->detail($berita_id)->getResult();
        $data['berita_random']  = $model->berita_random()->getResult();
        return view('frontend/berita_detail',$data);
    }
}
