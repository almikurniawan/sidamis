<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\kontak_model;
class Kontak extends BaseController
{
    // public function __construct() {
    //
    //      // Mendeklarasikan class ProductModel menggunakan $this->product
    //      $this->kontak = new kontak_model();
    //      /* Catatan:
    //      Apa yang ada di dalam function construct ini nantinya bisa digunakan
    //      pada function di dalam class Product
    //      */
    // }
    public function index()
    {
        $model = new kontak_model();
        $data['kontak']  = $model->get()->getResult();
        return view('frontend/kontak',$data);
    }

    public function kirim_pesan()
    {
        $model = new kontak_model();
        $data = array(
            'kontak_nama'        => $this->request->getPost('nama'),
            'kontak_email'       => $this->request->getPost('email'),
            'kontak_telp'        => $this->request->getPost('telp'),
            'kontak_subjek'      => $this->request->getPost('subjek'),
            'kontak_pesan'       => $this->request->getPost('pesan'),
        );
        $model->kirim_pesan($data);
        return redirect()->to(base_url('/kontak'));
    }
}
