<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Home extends BaseController
{
    public function index()
    {
        $data['search_miskin']  = $this->searchMiskin();
        $data['data_resume_miskin'] = $this->dataResumeMiskin();
        $data['data_miskin'] = $this->dataMiskin();
        $data['data_disabilitas'] = $this->dataDisabilitas();
        $data['data_penyakit'] = $this->dataPenyakit();
        return view('admin/dashboard', $data);
    }

    private function dataResumeMiskin()
    {
        $where = [];
        if($this->request->getGet('kecamatan')!=''){
            $where[] = " ruta_kd_kec = ".$this->request->getGet('kecamatan');
            if($this->request->getGet('desa')!=''){
                $where[] = " ruta_kd_desa = ".$this->request->getGet('desa');
            }
        }
        $whereClause = "";
        if(!empty($where)){
            $whereClause = " where ".implode(" and ", $where);
        }

        $SQL = "SELECT COUNT
                    ( * ) AS jumlah,
                    ruta_tahun,
                    periode_label,
                    ruta_tahun, 
                    periode_id
                FROM
                    ruta
                    left join ref_periode on ref_periode.periode_id = ruta_periode
                ".$whereClause."
                GROUP BY
                    ruta_tahun,
                    periode_label,
                    ruta_tahun, 
                    periode_id
                    order by ruta_tahun, periode_id";
        $data = $this->db->query($SQL)->getResultArray();
        $result = array();
        $data_miskin = array();
        foreach ($data as $key => $value) {
            $result['categories'][] = $value['ruta_tahun'] . " " . $value['periode_label'];
            $data_miskin[] = $value['jumlah'];
        }
        $result['series'][0]['name'] = "Ruta Kemiskinan";
        $result['series'][0]['data'] = $data_miskin;

        $SQL_ART = "SELECT SUM
                    ( ruta_jumlah_art ) AS jumlah,
                    ruta_tahun,
                    periode_label,
                    ruta_tahun, 
                    periode_id
                FROM
                    ruta
                    left join ref_periode on ref_periode.periode_id = ruta_periode
                ".$whereClause."
                GROUP BY
                    ruta_tahun,
                    periode_label,
                    ruta_tahun, 
                    periode_id
                    order by ruta_tahun, periode_id";
        $data_art = $this->db->query($SQL_ART)->getResultArray();
        $data_miskin_art = array();
        foreach ($data_art as $key => $value) {
            $data_miskin_art[] = $value['jumlah'];
        }
        $result['series'][1]['name'] = "Art Kemiskinan";
        $result['series'][1]['data'] = $data_miskin_art;

        $SQL_KK = "SELECT SUM
                    ( ruta_jumlah_kk ) AS jumlah,
                    ruta_tahun,
                    periode_label,
                    ruta_tahun, 
                    periode_id
                FROM
                    ruta
                    left join ref_periode on ref_periode.periode_id = ruta_periode
                ".$whereClause."
                GROUP BY
                    ruta_tahun,
                    periode_label,
                    ruta_tahun, 
                    periode_id
                    order by ruta_tahun, periode_id";
        $data_kk = $this->db->query($SQL_KK)->getResultArray();
        $data_miskin_kk = array();
        foreach ($data_kk as $key => $value) {
            $data_miskin_kk[] = $value['jumlah'];
        }
        $result['series'][2]['name'] = "KK Kemiskinan";
        $result['series'][2]['data'] = $data_miskin_kk;

        return $result;
    }

    private function dataMiskin()
    {
        $where = [];
        if($this->request->getGet('kecamatan')!=''){
            $where[] = " ruta_kd_kec = ".$this->request->getGet('kecamatan');
            if($this->request->getGet('desa')!=''){
                $where[] = " ruta_kd_desa = ".$this->request->getGet('desa');
            }
        }
        $whereClause = "";
        if(!empty($where)){
            $whereClause = " where ".implode(" and ", $where);
        }

        $SQL = "SELECT COUNT
                    ( * ) AS jumlah,
                    ruta_tahun,
                    periode_label,
                    ruta_tahun, 
                    periode_id
                FROM
                    ruta
                    left join ref_periode on ref_periode.periode_id = ruta_periode
                ".$whereClause."
                GROUP BY
                    ruta_tahun,
                    periode_label,
                    ruta_tahun, 
                    periode_id
                    order by ruta_tahun, periode_id";
        $data = $this->db->query($SQL)->getResultArray();
        $result = array();
        $data_miskin = array();
        foreach ($data as $key => $value) {
            $result['categories'][] = $value['ruta_tahun'] . " " . $value['periode_label'];
            $data_miskin[] = $value['jumlah'];
        }
        $result['series'][0]['name'] = "Ruta Kemiskinan";
        $result['series'][0]['data'] = $data_miskin;
        return $result;
    }

    private function dataDisabilitas()
    {
        $where = ['art_jns_cacat > 0'];
        if($this->request->getGet('kecamatan')!=''){
            $where[] = " ruta_kd_kec = ".$this->request->getGet('kecamatan');
            if($this->request->getGet('desa')!=''){
                $where[] = " ruta_kd_desa = ".$this->request->getGet('desa');
            }
        }
        $whereClause = "";
        if(!empty($where)){
            $whereClause = " where ".implode(" and ", $where);
        }

        $SQL = "SELECT COUNT
                    ( * ) AS jumlah,
                    art_tahun,
                    periode_label,
                    art_periode
                FROM
                    art 
                    left join ref_periode on ref_periode.periode_id = art_periode
                    LEFT JOIN ruta ON ruta_tahun = art_tahun 
                                    AND ruta_periode = art_periode 
                                    AND ruta_id_bdt = art_bdt_id
                    ".$whereClause."
                GROUP BY
                    art_tahun,
                    periode_label,
                    art_periode
                    order by art_tahun, art_periode";
        $data = $this->db->query($SQL)->getResultArray();
        $result = array();
        $data_disabilitas = array();
        foreach ($data as $key => $value) {
            $result['categories'][] = $value['art_tahun'] . " " . $value['periode_label'];
            $data_disabilitas[] = $value['jumlah'];
        }
        $result['series'][0]['name'] = "Disabilitas";
        $result['series'][0]['data'] = $data_disabilitas;
        return $result;
    }

    private function dataPenyakit()
    {
        $where = ['art_penyakit_kronis > 0'];
        if($this->request->getGet('kecamatan')!=''){
            $where[] = " ruta_kd_kec = ".$this->request->getGet('kecamatan');
            if($this->request->getGet('desa')!=''){
                $where[] = " ruta_kd_desa = ".$this->request->getGet('desa');
            }
        }
        $whereClause = "";
        if(!empty($where)){
            $whereClause = " where ".implode(" and ", $where);
        }

        $SQL = "SELECT COUNT
                    ( * ) AS jumlah,
                    art_tahun,
                    periode_label,
                    art_periode
                FROM
                    art 
                    left join ref_periode on ref_periode.periode_id = art_periode
                    LEFT JOIN ruta ON ruta_tahun = art_tahun 
                                    AND ruta_periode = art_periode 
                                    AND ruta_id_bdt = art_bdt_id
                    ".$whereClause."
                GROUP BY
                    art_tahun,
                    periode_label,
                    art_periode
                    order by art_tahun, art_periode";
        $data = $this->db->query($SQL)->getResultArray();
        $result = array();
        $data_penyakit = array();
        foreach ($data as $key => $value) {
            $result['categories'][] = $value['art_tahun'] . " " . $value['periode_label'];
            $data_penyakit[] = $value['jumlah'];
        }
        $result['series'][0]['name'] = "Penyakit";
        $result['series'][0]['data'] = $data_penyakit;
        return $result;
    }

    private function searchMiskin()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('kecamatan', 'Kecamatan', 'select', false, $this->request->getGet('kecamatan'), 'style="width:100%;" ',[
                'table'=> 'ref_kecamatan',
                'id'=> 'kec_kode',
                'label'=> 'kec_label'
            ])
            ->add('desa', 'Desa', 'select_rbi', false, $this->request->getGet('desa'), 'style="width:100%;" ', [
                'url' => base_url('admin/home/getDesa'),
                'cascade' => ['kecamatan'],
            ])
            ->output();
    }

    public function getDesa()
    {
        $filter = $this->request->getGet('filter');
        $ruta_kd_kec = $this->request->getGet('kecamatan');
        $where = "";
        if($filter['filters'][0]['value']!='' && $filter['filters'][0]['operator']=='contains'){
            $where = " and lower(desa_label) like '%".$filter['filters'][0]['value']."%'";
        }
        $data_desa = $this->db->query("select desa_kode as id, desa_label as value from ref_desa where desa_kode_kec=".$ruta_kd_kec." ".$where)->getResultArray();
        return $this->response->setJSON([
            'total' => count($data_desa),
            'data'  => $data_desa
        ]);
    }
}
