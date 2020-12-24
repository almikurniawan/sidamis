<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Informasi extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Informasi';

        return view('admin/informasi/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    informasi_id as id, *,
                    '<button onclick=\"approve('||informasi_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    informasi";

        $action['edit']     = array(
            'link'          => 'admin/informasi/edit/'
        );
        $action['detail']     = array(
            'jsf'          => 'lihatInformasi'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteInformasi'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('informasi_nama', $this->request->getGet('informasi_nama')),
          ))
            ->set_sort(array('id', 'asc'))
            // ->set_snippet(function($id, $data){
            //     $data['informasi_name'] = $data['informasi_name'];
            //     return $data;
            // })
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/informasi/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'informasi_nama',
                            'title' => 'Nama informasi',
                        ),
                        array(
                            'field' => 'informasi_tanggal',
                            'title' => 'Tanggal',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'informasi_foto',
                            'title' => 'Foto',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'informasi_isi',
                            'title' => 'Konten',
                            'encoded'=> true
                        ),
                        array(
                            'field' => 'informasi_file',
                            'title' => 'File',
                            'encoded'=> true
                        ),
                        array(
                            'field' => 'informasi_foto',
                            'title' => 'Foto',
                            'encoded'=> true
                        ),
                        array(
                            'field' => 'approve',
                            'title' => 'Approve',
                            'encoded'=> false
                        ),

                    ),
                    'action'    => $action,
                )
            )
            ->set_toolbar(function($toolbar){
                $toolbar
                ->addHtml('<a href="" class="btn ">Print PDF</a>')
                ->add('add', ['label'=>'Tambah informasi', 'url'=> base_url("admin/informasi/add")])
                ->add('download')
                ;
            })
            ->output();
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Search')
            ->add('informasi_nama', 'Nama informasi', 'text', false, $this->request->getGet('informasi_nama'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah informasi';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/informasi");
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit informasi';
        $data['form']   = $this->form($id);
        $data['url_back']= base_url("admin/informasi");
        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('informasi')->delete(['informasi_id' => $id]);
        return $this->response->setJSON(
            array(
                'status' => true,
                'message' => 'Success delete data'
            )
        );
    }
    public function form($id = null)
    {
        $data = array();
        if ($id != null) {
            $data = $this->db->table('informasi')->getWhere(['informasi_id' => $id])->getRowArray();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('informasi_nama', 'Nama informasi', 'text', true, (!empty($data)) ? $data['informasi_nama'] : '', 'style="width:100%;"')
            ->add('informasi_tanggal', 'Tanggal', 'date', true, (!empty($data)) ? $data['informasi_tanggal'] : '', 'style="width:100%;"')
            ->add('informasi_isi', 'Konten', 'text', true, (!empty($data)) ? $data['informasi_isi'] : '', 'style="width:100%;"')
            ->add('informasi_file', 'File', 'file', false, (!empty($data)) ? base_url("uploads/informasi")."/".$data['informasi_file'] : '', 'style="width:100%;"')
            ->add('informasi_foto', 'Foto', 'file', false, (!empty($data)) ? base_url("uploads/informasi")."/".$data['informasi_foto'] : '', 'style="width:100%;"');
        if ($form->formVerified()) {
            // die(print_r($form->get_data()));
            $data_insert = $form->get_data();
            $file1 = $this->request->getFile('informasi_file');
            $name1 = $file->getRandomName();
            if ($file1->getName() != '') {
              if ($file1->move('./uploads/informasi/', $name1)) {
                $data_insert['informasi_file'] = $name1;
              }
            }
            $file2 = $this->request->getFile('informasi_foto');
            $name2 = $file->getRandomName();
            if ($file2->getName() != '') {
              if ($file->move('./uploads/informasi/', $name2)) {
                $data_insert['informasi_foto'] = $name2;
              }
            }
            // $data_insert = array(
            //     'informasi_nama'    => $this->request->getPost('informasi_nama'),
            //     'informasi_tanggal'    => $this->request->getPost('informasi_tanggal'),
            //     'informasi_isi'    => $this->request->getPost('informasi_isi'),
            //     'informasi_file'    => $this->request->getPost('informasi_file'),
            //     'informasi_foto'    => $this->request->getPost('informasi_foto'),
            //     // 'informasi_password'    => sha1($this->request->getPost('informasi_password')),
            // );
            if ($id != null) {
                $this->db->table('public.informasi')->where('informasi_id', $id)->update($data_insert);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.informasi')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            die(forceRedirect(base_url('/admin/informasi')));
        } else {
            return $form->output();
        }
    }
}
