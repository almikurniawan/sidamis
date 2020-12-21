<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Kontak extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Kontak';

        return view('admin/kontak/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    kontak_id||'/'||kontak_nama as id, *,
                    '<button onclick=\"approve('||kontak_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    kontak";

        $action['edit']     = array(
            'link'          => 'admin/kontak/edit/'
        );
        $action['detail']     = array(
            'link'          => 'admin/kontak/detail/'
        );
        $action['delete']     = array(
            'jsf'          => 'deletekontak'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('kontak_nama', $this->request->getGet('kontak_nama')),
          ))
            ->set_sort(array('id', 'asc'))
            // ->set_snippet(function($id, $data){
            //     $data['kontak_name'] = $data['kontak_name'];
            //     return $data;
            // })
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/kontak/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'kontak_nama',
                            'title' => 'Nama',
                        ),
                        array(
                            'field' => 'kontak_email',
                            'title' => 'Email',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'kontak_telp',
                            'title' => 'Telp',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'kontak_subjek',
                            'title' => 'Subjek',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'kontak_pesan',
                            'title' => 'Pesan',
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
            ->add('kontak_judul', 'Nama kontak', 'text', false, $this->request->getGet('kontak_nama'), 'style="width:100%;" ')
            ->output();
    }



    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('kontak')->delete(['kontak_id' => $id]);
        return $this->response->setJSON(
            array(
                'status' => true,
                'message' => 'Success delete data'
            )
        );
    }

}
