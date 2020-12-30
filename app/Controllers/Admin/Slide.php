<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class slide extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Slide';

        return view('admin/slide/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    slide_id as id, *,
                    '<button onclick=\"approve('||slide_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    slide";

        $action['edit']     = array(
            'link'          => 'admin/slide/edit/'
        );
        $action['detail']     = array(
            'jsf'          => 'lihatSlide'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteSlide'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('slide_judul', $this->request->getGet('slide_judul')),
          ))
            ->set_sort(array('id', 'asc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/slide/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'slide_judul',
                            'title' => 'Judul slide',
                        ),
                        array(
                            'field' => 'slide_tag',
                            'title' => 'Tag',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'slide_foto',
                            'title' => 'Foto',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'slide_link',
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
                    ->add('add', ['label'=>'Tambah slide', 'url'=> base_url("admin/slide/add")]);
            })
            ->output();
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Search')
            ->add('slide_judul', 'Judul slide', 'text', false, $this->request->getGet('slide_judul'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah slide';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/slide");
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit slide';
        $data['form']   = $this->form($id);
        $data['url_back']= base_url("admin/slide");
        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('slide')->delete(['slide_id' => $id]);
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
            $data = $this->db->table('slide')->getWhere(['slide_id' => $id])->getRowArray();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('slide_judul', 'Judul slide', 'text', true, (!empty($data)) ? $data['slide_judul'] : '', 'style="width:100%;"')
            ->add('slide_tag', 'Tag', 'text', true, (!empty($data)) ? $data['slide_tag'] : '', 'style="width:100%;"')
            ->add('slide_foto', 'Foto', 'file', false, (!empty($data)) ? base_url("uploads/slide")."/".$data['slide_foto'] : '', 'style="width:100%;"')
            ->add('slide_link', 'Link', 'text', true, (!empty($data)) ? $data['slide_link'] : '', 'style="width:100%;"');
        if ($form->formVerified()) {
            // die(print_r($form->get_data()));
            $data_insert = $form->get_data();
            $file = $this->request->getFile('slide_foto');
            $name = $file->getRandomName();
            if ($file->getName() != '') {
              if ($file->move('./uploads/slide/', $name)) {
                // harus e gini doang sih zin
                $data_insert['slide_foto'] = $name;
              }
            }
            // $data_insert = array(
            //     'slide_judul'    => $this->request->getPost('slide_judul'),
            //     'slide_tag'    => $this->request->getPost('slide_tag'),
            //     'slide_foto'    => $this->request->getPost('slide_foto'),
            //     'slide_link'    => $this->request->getPost('slide_link'),
            //     // 'slide_password'    => sha1($this->request->getPost('slide_password')),
            // );
            if ($id != null) {
                $this->db->table('public.slide')->where('slide_id', $id)->update($data_insert);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.slide')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            die(forceRedirect(base_url('/admin/slide')));
        } else {
            return $form->output();
        }
    }
}
