<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Gallery extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Gallery';

        return view('admin/gallery/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    gallery_id||'/'||gallery_nama as id, *,
                    '<button onclick=\"approve('||gallery_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    gallery";

        $action['edit']     = array(
            'link'          => 'admin/gallery/edit/'
        );
        $action['detail']     = array(
            'link'          => 'admin/gallery/detail/'
        );
        $action['delete']     = array(
            'jsf'          => 'deletegallery'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('gallery_nama', $this->request->getGet('gallery_nama')),
          ))
            ->set_sort(array('id', 'asc'))
            // ->set_snippet(function($id, $data){
            //     $data['gallery_name'] = $data['gallery_name'];
            //     return $data;
            // })
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/gallery/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'gallery_nama',
                            'title' => 'Nama gallery',
                        ),
                        array(
                            'field' => 'gallery_foto',
                            'title' => 'Foto',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'gallery_deskripsi',
                            'title' => 'Deskripsi',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'kategori_id',
                            'title' => 'Kategori',
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
                ->add('add', ['label'=>'Tambah gallery', 'url'=> base_url("admin/gallery/add")])
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
            ->add('gallery_judul', 'Nama gallery', 'text', false, $this->request->getGet('gallery_nama'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah gallery';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/gallery");
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit gallery';
        $data['form']   = $this->form($id);
        $data['url_back']= base_url("admin/gallery");
        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('gallery')->delete(['gallery_id' => $id]);
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
            $data = $this->db->table('gallery')->getWhere(['gallery_id' => $id])->getRowArray();
        } else {
            $data = array(
                'group' => array(),
                'gallery_nama' => '',
                'gallery_foto' => '',
                'gallery_deskripsi' => '',
                'gallery_kategori' => '',
            );
            $group = array();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('gallery_nama', 'Nama gallery', 'text', true, ($data) ? $data['gallery_nama'] : '', 'style="width:100%;"')
            ->add('gallery_foto', 'Logo', 'text', true, ($data) ? $data['gallery_foto'] : '', 'style="width:100%;"')
            ->add('gallery_deskripsi', 'Link', 'text', true, ($data) ? $data['gallery_deskripsi'] : '', 'style="width:100%;"')
            ->add('gallery_kategori', 'Link', 'text', true, ($data) ? $data['gallery_kategori'] : '', 'style="width:100%;"');
        if ($form->formVerified()) {
            die(print_r($form->get_data()));
            $data_insert = array(
                'gallery_nama'    => $this->request->getPost('gallery_nama'),
                'gallery_foto'    => $this->request->getPost('gallery_foto'),
                'gallery_deskripsi'    => $this->request->getPost('gallery_deskripsi'),
                'gallery_kategori'    => $this->request->getPost('gallery_kategori'),
                // 'gallery_password'    => sha1($this->request->getPost('gallery_password')),
            );
            if ($id != null) {
                $this->db->table('public.gallery')->where('gallery_id', $id)->update($data_insert);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.gallery')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            die(forceRedirect(base_url('/admin/gallery')));
        } else {
            return $form->output();
        }
    }
}
