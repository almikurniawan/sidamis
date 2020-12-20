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
        $data['title']  = 'layanan';

        return view('admin/layanan/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    layanan_id||'/'||layanan_nama as id, *,
                    '<button onclick=\"approve('||layanan_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    layanan";

        $action['edit']     = array(
            'link'          => 'admin/layanan/edit/'
        );
        $action['detail']     = array(
            'link'          => 'admin/layanan/detail/'
        );
        $action['delete']     = array(
            'jsf'          => 'deletelayanan'
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
            ->add('layanan_judul', 'Judul layanan', 'text', false, $this->request->getGet('layanan_judul'), 'style="width:100%;" ')
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
        $this->db->table('layanan')->delete(['layanan_id' => $id]);
        return $this->response->setJSON(
            array(
                'status' => true,
                'message' => 'Success delete data'
            )
        );
    }
    public function form($id = null)
    {

        if ($id != null) {
            $data = $this->db->table('layanan')->getWhere(['layanan_id' => $id])->getRowArray();
        } else {
            $data = array(
                'group' => array(),
                'layanan_nama' => '',
                'layanan_deskripsi' => '',
                'layanan_foto' => '',
                'layanan_icon' => '',
            );
            $group = array();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('layanan_nama', 'Nama Layanan', 'text', true, ($data) ? $data['layanan_nama'] : '', 'style="width:100%;"')
            ->add('layanan_deskripsi', 'Deskripsi', 'text', true, ($data) ? $data['layanan_deskripsi'] : '', 'style="width:100%;"');
        if ($form->formVerified()) {
            die(print_r($form->get_data()));
            $data_insert = array(
                'layanan_nama'    => $this->request->getPost('layanan_nama'),
                'layanan_deskrispi'    => $this->request->getPost('layanan_deskripsi'),
                // 'layanan_password'    => sha1($this->request->getPost('layanan_password')),
            );
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
