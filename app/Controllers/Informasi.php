<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\informasi_model;
class informasi extends BaseController
{
    // public function __construct() {
    //
    //      // Mendeklarasikan class ProductModel menggunakan $this->product
    //      $this->informasi = new informasi_model();
    //      /* Catatan:
    //      Apa yang ada di dalam function construct ini nantinya bisa digunakan
    //      pada function di dalam class Product
    //      */
    // }
    public function index()
    {
        $model = new informasi_model();
        $data = [
            'informasi' => $model->asObject()->paginate(10,'btinformasi'),
            'pager' => $model->pager
        ];
        // $data['informasi']  = $model->get()->getResult();
        return view('frontend/informasi',$data);
    }

    public function detail($informasi_id)
    {
        $model = new informasi_model();
        $data['informasi_detail']  = $model->detail($informasi_id)->getResult();
        $data['informasi_random']  = $model->informasi_random()->getResult();
        return view('frontend/informasi_detail',$data);
    }

    public function search()
    {
        $search=$this->request->getGet('search');
        $model = new informasi_model();
        $data = [
            'informasi' => $model->like('informasi_nama', $search)->asObject()->paginate(10,'btinformasi'),
            'pager' => $model->pager
        ];
        // $data['informasi']  = $model->get()->getResult();
        return view('frontend/informasi',$data);
    }
}
