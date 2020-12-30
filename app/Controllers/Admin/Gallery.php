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
                    gallery_id as id, *,
                    '<button onclick=\"approve('||gallery_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    gallery";

        $action['edit']     = array(
            'link'          => 'admin/gallery/edit/'
        );
        $action['detail']     = array(
            'jsf'          => 'lihatGallery'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteGallery'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('gallery_nama', $this->request->getGet('gallery_nama')),
          ))
            ->set_sort(array('id', 'asc'))
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
                            'field' => 'gallery_kategori_id',
                            'title' => 'Kategori gallery',
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
                ->add('add', ['label'=>'Tambah gallery', 'url'=> base_url("admin/gallery/add")]);
            })
            ->output();
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Search')
            ->add('gallery_nama', 'Nama gallery', 'text', false, $this->request->getGet('gallery_nama'), 'style="width:100%;" ')
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
        $data = array();
        if ($id != null) {
            $data = $this->db->table('gallery')->getWhere(['gallery_id' => $id])->getRowArray();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('gallery_nama', 'Nama gallery', 'text', true, (!empty($data)) ? $data['gallery_nama'] : '', 'style="width:100%;"')
            ->add('gallery_foto', 'Logo', 'file', false, (!empty($data)) ? base_url("uploads/gallery")."/".$data['gallery_foto'] : '', 'style="width:100%;"')
            ->add('gallery_deskripsi', 'Deskripsi', 'textArea', true, (!empty($data)) ? $data['gallery_deskripsi'] : '', 'style="width:100%;"')
            ->add('gallery_kategori_id', 'Kategori gallery', 'select', false, (!empty($data)) ? $data['gallery_kategori_id'] : '', ' style="width:100%;"', array(
                'table' => 'public.gallery_kategori',
                'id' => 'gallery_kategori_id',
                'label' => 'gallery_kategori_nama',
            ));
        if ($form->formVerified()) {
            $data_insert = $form->get_data();
            $file = $this->request->getFile('gallery_foto');
            $name = $file->getRandomName();
            if ($file->getName() != '') {
              if ($file->move('./uploads/gallery/', $name)) {
                $data_insert['gallery_foto'] = $name;
              }
            }
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
