<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Berita extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Berita';

        return view('admin/berita/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    berita_id as id, *,
                    '<button onclick=\"approve('||berita_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    berita";

        $action['edit']     = array(
            'link'          => 'admin/berita/edit/'
        );
        $action['detail']     = array(
            'jsf'          => 'lihatBerita'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteBerita'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('berita_judul', $this->request->getGet('berita_judul')),
            array('berita_tanggal', $this->request->getGet('berita_tanggal'),'='),
          ))
            ->set_sort(array('id', 'asc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/berita/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'berita_judul',
                            'title' => 'Judul Berita',
                        ),
                        array(
                            'field' => 'berita_tanggal',
                            'title' => 'Tanggal',
                            'format' => 'date',
                        ),
                        array(
                            'field' => 'berita_konten',
                            'title' => 'Konten',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'berita_foto',
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
                ->add('add', ['label'=>'Tambah berita', 'url'=> base_url("admin/berita/add")]);
            })
            ->output();
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Search')
            ->add('berita_judul', 'Judul berita', 'text', false, $this->request->getGet('berita_judul'), 'style="width:100%;" ')
            ->add('berita_tanggal', 'Judul tanggal', 'date', false, $this->request->getGet('berita_tanggal'), 'style="width:100%;" ')
            // ->add('berita_tipe', 'Judul tipe', 'select', false, $this->request->getGet('berita_tipe'), 'style="width:100%;" ', array(
            //   'table'=>'public.user',
            //   'id' => 'user_id',
            //   'label' => 'user_name'
            // ))
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah berita';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/berita");
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit user';
        $data['form']   = $this->form($id);
        $data['url_back']= base_url("admin/berita");
        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('berita')->delete(['berita_id' => $id]);
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
            $data = $this->db->table('berita')->getWhere(['berita_id' => $id])->getRowArray();
        }
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('berita_judul', 'Judul berita', 'text', true, (!empty($data)) ? $data['berita_judul'] : '', 'style="width:100%;"')
            ->add('berita_tanggal', 'Tanggal berita', 'date', true, (!empty($data)) ? $data['berita_tanggal'] : '', 'style="width:100%;"')
            ->add('berita_konten', 'Konten berita', 'textArea', true, (!empty($data)) ? $data['berita_konten'] : '', 'style="width:100%;"')
            ->add('berita_foto', 'Foto berita', 'file', false, (!empty($data)) ? base_url("uploads/berita")."/".$data['berita_foto'] : '', 'style="width:100%;"');
            // ->add('ref_user_akses_group_id', 'Nama Group', 'select_multiple', false, ($data) ? $group : '', ' style="width:100%;"', array(
            //     'table' => 'ref_group_akses',
            //     'id' => 'ref_group_akses_id',
            //     'label' => 'ref_group_akses_label',
            // ));
        if ($form->formVerified()) {
            // die(print_r($form->get_data()));
            $data_insert = $form->get_data();
            $file = $this->request->getFile('berita_foto');
            $name = $file->getRandomName();
            if ($file->getName() != '') {
              if ($file->move('./uploads/berita/', $name)) {
                $data_insert['berita_foto'] = $name;
              }
            }
            if ($id != null) {
                $this->db->table('public.berita')->where('berita_id', $id)->update($data_insert);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.berita')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            die(forceRedirect(base_url('/admin/berita')));
        } else {
            return $form->output();
        }
    }
}
