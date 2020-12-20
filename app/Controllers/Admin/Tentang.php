<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class tentang extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Tentang';

        return view('admin/tentang/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    tentang_id||'/'||tentang_judul as id, *,
                    '<button onclick=\"approve('||tentang_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    tentang";

        $action['edit']     = array(
            'link'          => 'admin/tentang/edit/'
        );
        $action['detail']     = array(
            'link'          => 'admin/tentang/detail/'
        );
        $action['delete']     = array(
            'jsf'          => 'deletetentang'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('tentang_judul', $this->request->getGet('tentang_judul')),
          ))
            ->set_sort(array('id', 'asc'))
            // ->set_snippet(function($id, $data){
            //     $data['tentang_name'] = $data['tentang_name'];
            //     return $data;
            // })
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/tentang/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'tentang_judul',
                            'title' => 'Judul tentang',
                        ),
                        array(
                            'field' => 'tentang_konten',
                            'title' => 'Konten',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'tentang_file',
                            'title' => 'Foto',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'tentang_tipe',
                            'title' => 'Link',
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
                ->add('add', ['label'=>'Tambah tentang', 'url'=> base_url("admin/tentang/add")])
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
            ->add('tentang_judul', 'Judul tentang', 'text', false, $this->request->getGet('tentang_judul'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah tentang';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/tentang");
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit tentang';
        $data['form']   = $this->form($id);
        $data['url_back']= base_url("admin/tentang");
        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('tentang')->delete(['tentang_id' => $id]);
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
            $data = $this->db->table('tentang')->getWhere(['tentang_id' => $id])->getRowArray();
        } else {
            $data = array(
                'group' => array(),
                'tentang_judul' => '',
                'tentang_konten' => '',
                'tentang_file' => '',
                'tentang_tipe' => '',
            );
            $group = array();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('tentang_judul', 'Judul tentang', 'text', true, ($data) ? $data['tentang_judul'] : '', 'style="width:100%;"')
            ->add('tentang_konten', 'Konten', 'text', true, ($data) ? $data['tentang_konten'] : '', 'style="width:100%;"')
            ->add('tentang_file', 'Foto', 'file', true, ($data) ? $data['tentang_file'] : '', 'style="width:100%;"')
            ->add('tentang_tipe', 'Link', 'text', true, ($data) ? $data['tentang_tipe'] : '', 'style="width:100%;"');
        if ($form->formVerified()) {
            die(print_r($form->get_data()));
            $data_insert = array(
                'tentang_judul'    => $this->request->getPost('tentang_judul'),
                'tentang_konten'    => $this->request->getPost('tentang_konten'),
                'tentang_file'    => $this->request->getPost('tentang_file'),
                'tentang_tipe'    => $this->request->getPost('tentang_tipe'),
                // 'tentang_password'    => sha1($this->request->getPost('tentang_password')),
            );
            if ($id != null) {
                $this->db->table('public.tentang')->where('tentang_id', $id)->update($data_insert);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.tentang')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            die(forceRedirect(base_url('/admin/tentang')));
        } else {
            return $form->output();
        }
    }
}
