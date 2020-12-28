<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Dinas extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Dinas';

        return view('admin/dinas/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    dinas_id||'/'||dinas_nama as id, *,
                    '<button onclick=\"approve('||dinas_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    dinas";

        $action['edit']     = array(
            'link'          => 'admin/dinas/edit/'
        );
        $action['detail']     = array(
            'jsf'          => 'lihatDinas'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteDinas'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('dinas_nama', $this->request->getGet('dinas_nama')),
          ))
            ->set_sort(array('id', 'asc'))
            // ->set_snippet(function($id, $data){
            //     $data['dinas_name'] = $data['dinas_name'];
            //     return $data;
            // })
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/dinas/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'dinas_nama',
                            'title' => 'Nama dinas',
                        ),
                        array(
                            'field' => 'dinas_logo',
                            'title' => 'Logo',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'dinas_link',
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
                ->add('add', ['label'=>'Tambah dinas', 'url'=> base_url("admin/dinas/add")])
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
            ->add('dinas_nama', 'Nama dinas', 'text', false, $this->request->getGet('dinas_nama'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah dinas';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/dinas");
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit dinas';
        $data['form']   = $this->form($id);
        $data['url_back']= base_url("admin/dinas");
        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('dinas')->where(['dinas_id' => $id])->delete();
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
            $data = $this->db->table('dinas')->getWhere(['dinas_id' => $id])->getRowArray();
        }
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('dinas_nama', 'Nama dinas', 'text', true, (!empty($data)) ? $data['dinas_nama'] : '', 'style="width:100%;"')
            ->add('dinas_logo', 'Logo', 'file', false, (!empty($data)) ? base_url("uploads/dinas")."/".$data['dinas_logo'] : '', 'style="width:100%;"')
            ->add('dinas_link', 'Link', 'text', true, (!empty($data)) ? $data['dinas_link'] : '', 'style="width:100%;"');
        if ($form->formVerified()) {
            // die(print_r($form->get_data()));
            // iki kan wes declare variabel dan enek isine
            $data_insert = $form->get_data();
            $file = $this->request->getFile('dinas_logo');
            $name = $file->getRandomName();
            if ($file->getName() != '') {
              if ($file->move('./uploads/dinas/', $name)) {
                // harus e gini doang sih zin
                $data_insert['dinas_logo'] = $name;
                // $data_insert = array(
                //     'dinas_nama'    => $this->request->getPost('dinas_nama'),
                //     'dinas_logo'    => $name,
                //     'dinas_link'    => $this->request->getPost('dinas_link'),
                //     // 'dinas_password'    => sha1($this->request->getPost('dinas_password')),
                // );
              }
            }
            // $data_insert = array(
            //     'dinas_nama'    => $this->request->getPost('dinas_nama'),
            //     'dinas_link'    => $this->request->getPost('dinas_link'),
            //     // 'dinas_password'    => sha1($this->request->getPost('dinas_password')),
            // );
            if ($id != null) {
                $this->db->table('public.dinas')->where('dinas_id', $id)->update($data_insert);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.dinas')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            die(forceRedirect(base_url('/admin/dinas')));
        } else {
            return $form->output();
        }
    }
}
