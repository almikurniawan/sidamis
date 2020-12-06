<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Karyawan extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Karyawan';
        $data['url_delete'] = 'admin/karyawan/delete';

        return view('global/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    kar_id as id,
                    *
                FROM
                    karyawan";

        $action['edit']     = array(
            'link'          => 'admin/karyawan/edit/'
        );
        $action['delete']     = array(
            'jsf'          => '_delete'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('kar_nama', $this->request->getGet('kar_nama')),
            array('kar_visible', 'true','is')
        ))
            ->set_sort(array('kar_id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/karyawan/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'kar_nama',
                            'title' => 'Nama Lengkap',
                        ),
                        array(
                            'field' => 'kar_nip',
                            'title' => 'NIP',
                        ),
                        array(
                            'field' => 'kar_pangkat',
                            'title' => 'Pangkat',
                        ),
                        array(
                            'field' => 'kar_jabatan',
                            'title' => 'Jabatan',
                        ),
                        array(
                            'field' => 'kar_created_at',
                            'title' => 'Tanggal buat',
                            'format'=> 'date'
                        ),
                    ),
                    'action'    => $action,
                    'head_left' => array('add' => base_url('/admin/karyawan/add')),
                    'toolbar'   => ['download']
                )
            )->output();
    }
    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('kar_nama', 'Karyawan', 'text', false, $this->request->getGet('kar_nama'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah Karyawan';
        $data['form']   = $this->form();
        $data['url_back'] = base_url('admin/karyawan');
        return view('global/form', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit Karyawan';
        $data['form']   = $this->form($id);
        $data['url_back'] = base_url('admin/karyawan');

        return view('global/form', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');

        $this->db->table('karyawan')->where(['kar_id' => $id])->update(['kar_visible' => false]);
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
            $data = $this->db->table('karyawan')->select('*')->join('public.user', 'kar_id=user_kar_id')->getWhere(['kar_id' => $id])->getRowArray();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('kar_nama', 'Nama Lengkap', 'text', true, !empty($data) ? $data['kar_nama'] : '', 'style="width:100%;"')
            ->add('kar_nip', 'NIP', 'text', true, !empty($data) ? $data['kar_nip'] : '', 'style="width:100%;"')
            ->add('kar_pangkat', 'Pangkat', 'text', true, !empty($data) ? $data['kar_pangkat'] : '', 'style="width:100%;"')
            ->add('kar_jabatan', 'Jabatan', 'text', true, !empty($data) ? $data['kar_jabatan'] : '', 'style="width:100%;"')
            ->add('user_name', 'Username', 'text', true, !empty($data) ? $data['user_name'] : '', 'style="width:100%;"')
            ->add('user_password', 'Password', 'password', true, !empty($data) ? '***' : '', 'style="width:100%;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $karyawan_update = array(
                    'kar_nama'  => $this->request->getPost('kar_nama'),
                    'kar_nip'   => $this->request->getPost('kar_nip'),
                    'kar_pangkat'   => $this->request->getPost('kar_pangkat'),
                    'kar_jabatan'   => $this->request->getPost('kar_jabatan'),
                    // 'kar_created_at'    => 'now()',
                    // 'kar_created_by'    => $this->user['user_id']
                );
                $this->db->table('karyawan')->where('kar_id', $id)->update($karyawan_update);

                $cekUser = $this->db->table('user')->getWhere(['user_name' => $this->request->getPost('user_name')])->getRowArray();
                if (!empty($cekUser)) {
                    $this->session->setFlashdata('danger', 'username = ' . strtoupper($this->request->getPost('user_name')) . ' sudah ada! Silahkan buat username yang baru');
                    die(forceRedirect(base_url('/admin/karyawan/edit/' . $id)));
                }
                $user_update = array(
                    'user_name'         => $this->request->getPost('user_name'),
                    'user_kar_id'     => $id,
                    'user_namalengkap'     => $this->request->getPost('kar_nama'),
                    'user_created_at'    => 'now()'
                );
                if ($this->request->getPost('user_password') != '') {
                    $user_update['user_password'] = sha1($this->request->getPost('user_password'));
                }
                $this->db->table('public.user')->where('user_member_id', $id)->update($user_update);
                $this->session->setFlashdata('success', 'Registrasi username = ' . strtoupper($this->request->getPost('user_name')) . ' berhasil! Silahkan login untuk melanjutkan');
                $this->session->setFlashdata('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/karyawan/edit/' . $id)));
            } else {
                $karyawan_update = array(
                    'kar_nama'  => $this->request->getPost('kar_nama'),
                    'kar_nip'   => $this->request->getPost('kar_nip'),
                    'kar_pangkat'   => $this->request->getPost('kar_pangkat'),
                    'kar_jabatan'   => $this->request->getPost('kar_jabatan'),
                    'kar_created_at'    => 'now()',
                    'kar_created_by'    => $this->user['user_id'],
                    'kar_visible'       => true
                );
                $this->db->table('karyawan')->insert($karyawan_update);
                $id = $this->db->insertID();

                $cekUser = $this->db->table('user')->getWhere(['user_name' => $this->request->getPost('user_name')])->getRowArray();
                if (!empty($cekUser)) {
                    $this->session->setFlashdata('danger', 'username = ' . strtoupper($this->request->getPost('user_name')) . ' sudah ada! Silahkan buat username yang baru');
                    die(forceRedirect(base_url('/admin/karyawan/edit/' . $id)));
                }
                $user_insert = array(
                    'user_name'         => $this->request->getPost('user_name'),
                    'user_kar_id'     => $id,
                    'user_namalengkap'     => $this->request->getPost('kar_nama'),
                    'user_created_at'    => 'now()'
                );
                if ($this->request->getPost('user_password') != '') {
                    $user_insert['user_password'] = sha1($this->request->getPost('user_password'));
                }
                $this->db->table('public.user')->insert($user_insert);
                $this->session->setFlashdata('success', 'Registrasi username = ' . strtoupper($this->request->getPost('user_name')) . ' berhasil! Silahkan login untuk melanjutkan');
                die(forceRedirect(base_url('/admin/karyawan/edit/' . $id)));
            }
        } else {
            return $form->output();
        }
    }
}
