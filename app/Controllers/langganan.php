<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\langganan_model;
class Langganan extends BaseController
{
    // public function __construct() {
    //
    //      // Mendeklarasikan class ProductModel menggunakan $this->product
    //      $this->langganan = new langganan_model();
    //      /* Catatan:
    //      Apa yang ada di dalam function construct ini nantinya bisa digunakan
    //      pada function di dalam class Product
    //      */
    // }
    public function save()
    {
        $model = new langganan_model();
        $data = array(
            'langganan_email'        => $this->request->getPost('langganan_email'),
        );
        $model->savelangganan($data);
        return redirect()->to(base_url());
    }

}
