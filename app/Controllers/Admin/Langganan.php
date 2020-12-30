<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Langganan extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'langganan';

        return view('admin/langganan/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    langganan_id||'/'||langganan_email as id, *,
                    '<button onclick=\"approve('||langganan_id||')\" class=\"btn btn-sm btn-success\">Approve</button>' as approve
                FROM
                    langganan";

        $action['delete']     = array(
            'jsf'          => 'deleteLangganan'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('langganan_nama', $this->request->getGet('langganan_nama')),
          ))
            ->set_sort(array('id', 'asc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/langganan/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'langganan_email',
                            'title' => 'Nama langganan',
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
                ->addHtml('<a href="" class="btn ">Print PDF</a>');
            })
            ->output();
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Search')
            ->add('langganan_email', 'Email langganan', 'text', false, $this->request->getGet('langganan_email'), 'style="width:100%;" ')
            ->output();
    }


    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('langganan')->delete(['langganan_id' => $id]);
        return $this->response->setJSON(
            array(
                'status' => true,
                'message' => 'Success delete data'
            )
        );
    }

}
