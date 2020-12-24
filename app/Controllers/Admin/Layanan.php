<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Layanan extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Layanan';

        return view('admin/layanan/list', $data);
    }

    public function grid()
    {
      // iki parameter id seng bakal di gae view, update, dan delete zin.
        $SQL = "SELECT
                    layanan_id as id, *,
                    '<button onclick=\"approve('||layanan_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    layanan";

        $action['edit']     = array(
            'link'          => 'admin/layanan/edit/'
        );
        $action['detail']     = array(
            'jsf'          => 'lihatLayanan'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteLayanan'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('layanan_nama', $this->request->getGet('layanan_nama')),
          ))
            ->set_sort(array('id', 'asc'))
            // ->set_snippet(function($id, $data){
            //     $data['layanan_name'] = $data['layanan_name'];
            //     return $data;
            // })
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/layanan/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'layanan_nama',
                            'title' => 'Nama layanan',
                        ),
                        // encode true itu render text, encoded false iku render html
                        array(
                            'field' => 'layanan_deskripsi',
                            'title' => 'Deskripsi',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'layanan_foto',
                            'title' => 'Foto',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'layanan_icon',
                            'title' => 'Icon',
                            'encoded'=> false
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
                ->add('add', ['label'=>'Tambah layanan', 'url'=> base_url("admin/layanan/add")])
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
            ->add('layanan_nama', 'Nama layanan', 'text', false, $this->request->getGet('layanan_nama'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah Layanan';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/layanan");
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit Layanan';
        $data['form']   = $this->form($id);
        $data['url_back']= base_url("admin/layanan");
        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        // dek ci4 query builder e beda emang. method update dan delete database gak enek parameter e
        $this->db->table('layanan')->where(['layanan_id' => $id])->delete();
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
            $data = $this->db->table('layanan')->getWhere(['layanan_id' => $id])->getRowArray();
        }
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('layanan_nama', 'Nama Layanan', 'text', true, (!empty($data)) ? $data['layanan_nama'] : '', 'style="width:100%;"')
            ->add('layanan_deskripsi', 'Deskripsi', 'text', true, (!empty($data)) ? $data['layanan_deskripsi'] : '', 'style="width:100%;"')
            ->add('layanan_foto', 'Foto', 'file', false, (!empty($data)) ? base_url("uploads/layanan")."/".$data['layanan_foto'] : '', 'style="width:100%;"')
            ->add('layanan_icon', 'Icon', 'textArea', true, (!empty($data)) ? $data['layanan_icon'] : '', 'style="width:100%;"');
        if ($form->formVerified()) {
            // die(print_r($form->get_data()));
            $data_insert = $form->get_data();
            $file = $this->request->getFile('layanan_foto');
            $name = $file->getRandomName();
            if ($file->getName() != '') {
              if ($file->move('./uploads/layanan/', $name)) {
                $data_insert['layanan_foto'] = $name;
              }
            }
            // $data_insert = array(
            //     'layanan_nama'    => $this->request->getPost('layanan_nama'),
            //     'layanan_deskripsi'    => $this->request->getPost('layanan_deskripsi'),
            //     'layanan_icon'    => $this->request->getPost('layanan_icon'),
            //     // 'dinas_password'    => sha1($this->request->getPost('dinas_password')),
            // );
            // die(print_r($data_insert));
            if ($id != null) {
                $this->db->table('public.layanan')->where('layanan_id', $id)->update($data_insert);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.layanan')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            die(forceRedirect(base_url('/admin/layanan')));
        } else {
            return $form->output();
        }
    }
}
