<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;
use App\Libraries\BackgroundProcess;

class HistoryImport extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = '';
        $data['title']  = 'History Import Data';
        $data['url_delete']  = '';
        
        return view('global/list', $data);
    }

    public function grid()
    {
        $SQL = "select *, import_id as id, case when import_execute is true then 'Sudah diproses' else 'Belum di proses' end || case when import_finish is true then ' dan sudah selesai' else '' end as status, case when import_jenis = 1 then 'RUTA' else 'ART' end || '<br/><a class=\"link\" target=\"_new\" href=\"".base_url()."/uploads/\'||import_file||'\">File</a>' as jenis from import left join ref_periode on import_periode = periode_id";

        $grid = new Grid();
        return $grid->set_query($SQL)
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/historyImport/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'id',
                            'title' => 'ID',
                        ),
                        array(
                            'field' => 'import_tahun',
                            'title' => 'Tahun',
                        ),
                        array(
                            'field' => 'periode_label',
                            'title' => 'Periode'
                        ),
                        array(
                            'field' => 'jenis',
                            'title' => 'Jenis & File',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'import_at',
                            'title' => 'Import At',
                            'format'=> 'datetime'
                        ),
                        array(
                            'field' => 'status',
                            'title' => 'Status'
                        ),
                        array(
                            'field' => 'import_keterangan_error',
                            'title' => 'Error',
                            'width' => 450
                        ),
                        array(
                            'field' => 'import_last_line_error',
                            'title' => 'Baris'
                        ),
                        
                    ),
                ),
            )
            ->output();
    }
}