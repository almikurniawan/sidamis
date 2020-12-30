<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;
use App\Libraries\BackgroundProcess;

class ImportRuta extends BaseController
{
    public function index()
    {
        $data['form']   = $this->form();
        $data['title']  = 'Import Ruta';
        $data['url_back']= base_url("admin/ruta");
        return view('global/form', $data);
    }

    public function form()
    {
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"  enctype="multipart/form-data"')
            ->set_submit_label("Import")
            ->add('file', 'File Excel', 'file', false, '', 'style="width:100%;"')
            ->add('tahun', 'Tahun', 'number', true, '', ' style="width:100%;"')
            ->add('periode', 'Periode', 'select', true, '', ' style="width:100%;"', array(
                'table' => 'ref_periode',
                'id' => 'periode_id',
                'label' => 'periode_label',
            ));
        if ($form->formVerified()) {
            $file = $this->request->getFile('file');
            $name = $file->getRandomName();
            if ($file->move('./uploads/', $name)) {
                $dataForm['import_file'] = $name;
                $dataForm['import_finish'] = false;
                $dataForm['import_at'] = date("Y-m-d H:i:s");
                $dataForm['import_by'] = $this->user['user_id'];
                $dataForm['import_tahun'] = $this->request->getPost('tahun');
                $dataForm['import_periode'] = $this->request->getPost('periode');
                $dataForm['import_jenis'] = 1;
                
                $this->db->table("import")->insert($dataForm);
                $id = $this->db->insertID();
                pclose(popen('start /B cmd /C "php \xampp7\htdocs\apps\sidamis\public\index.php import ruta '.$id.'"','r'));
            }
            die(forceRedirect(base_url('/admin/historyImport')));
        } else {
            return $form->output();
        }
    }

}