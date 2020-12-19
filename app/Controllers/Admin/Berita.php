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
                    berita_id||'/'||berita_judul as id, *,
                    '<button onclick=\"approve('||berita_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    berita";

        $action['edit']     = array(
            'link'          => 'admin/aksesUser/edit/'
        );
        $action['detail']     = array(
            'link'          => 'admin/berita/detail/'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteUser'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('berita_judul', $this->request->getGet('berita_judul')),
            array('berita_tanggal', $this->request->getGet('berita_tanggal'),'='),
          ))
            ->set_sort(array('id', 'asc'))
            // ->set_snippet(function($id, $data){
            //     $data['user_name'] = $data['user_name'];
            //     return $data;
            // })
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
                ->add('add', ['label'=>'Tambah berita', 'url'=> base_url("admin/berita/add")])
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
            ->add('berita_judul', 'Judul berita', 'text', false, $this->request->getGet('berita_judul'), 'style="width:100%;" ')
            ->add('berita_tanggal', 'Judul tanggal', 'date', false, $this->request->getGet('berita_tanggal'), 'style="width:100%;" ')
            ->add('berita_tipe', 'Judul tipe', 'select', false, $this->request->getGet('berita_tipe'), 'style="width:100%;" ', array(
              'table'=>'public.user',
              'id' => 'user_id',
              'label' => 'user_name'
            ))
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah user';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/berita");
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit user';
        $data['form']   = $this->form($id);
        $data['url_back']= base_url("admin/aksesUser");
        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('ref_user_akses')->delete(['ref_user_akses_id' => $id]);
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
            $data = $this->db->table('user')->getWhere(['user_id' => $id])->getRowArray();
            $group = $this->db->table('ref_user_akses')->select('ref_user_akses_group_id')->getWhere(['ref_user_akses_user_id' => $id])->getResultArray();
            foreach ($group as $key => $value) {
                $group[] = $value['ref_user_akses_group_id'];
            }
        } else {
            $data = array(
                'group' => array(),
                'user_name' => '',
                'user_password' => '',
                'user_namalengkap' => '',
            );
            $group = array();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('user_namalengkap', 'Nama Lengkap', 'text', true, ($data) ? $data['user_namalengkap'] : '', 'style="width:100%;"')
            ->add('user_name', 'Username', 'text', true, ($data) ? $data['user_name'] : '', 'style="width:100%;"')
            ->add('user_password', 'Password', 'password', false, '', 'style="width:100%;"')
            ->add('ref_user_akses_group_id', 'Nama Group', 'select_multiple', false, ($data) ? $group : '', ' style="width:100%;"', array(
                'table' => 'ref_group_akses',
                'id' => 'ref_group_akses_id',
                'label' => 'ref_group_akses_label',
            ));
        if ($form->formVerified()) {
            die(print_r($form->get_data()));
            $data_insert = array(
                'user_namalengkap'    => $this->request->getPost('user_namalengkap'),
                'user_name'    => $this->request->getPost('user_name'),
                // 'user_password'    => sha1($this->request->getPost('user_password')),
            );
            if($this->request->getPost('user_password')!=''){
                $data_insert['user_password'] = sha1($this->request->getPost('user_password'));
            }
            if ($id != null) {
                $this->db->table('public.user')->where('user_id', $id)->update($data_insert);
                $this->db->table('ref_user_akses')->delete(['ref_user_akses_user_id' => $id]);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.user')->insert($data_insert);
                $id = $this->db->insertID();
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            foreach ($this->request->getPost('ref_user_akses_group_id') as $key => $value) {
                $this->db->table('ref_user_akses')->insert(array(
                    'ref_user_akses_user_id' => $id,
                    'ref_user_akses_group_id' => $value
                ));
            }
            die(forceRedirect(base_url('/admin/aksesUser')));
        } else {
            return $form->output();
        }
    }
}
