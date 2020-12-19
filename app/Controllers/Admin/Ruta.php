<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;
use App\Libraries\BackgroundProcess;

class Ruta extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Ruta';
        
        return view('admin/ruta/list', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
                    ruta_id as id,
                    * 
                from ruta ";

        $grid = new Grid();
        return $grid->set_query($SQL, array(
                array('ruta_id_bdt', $this->request->getGet('ruta_id_bdt'),'='),
                array('ruta_nama_krt', $this->request->getGet('ruta_nama_krt')),
                array('ruta_alamat', $this->request->getGet('ruta_alamat')),
            ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/ruta/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ruta_id_bdt',
                            'title' => 'IDBDT',
                        ),
                        array(
                            'field' => 'ruta_tahun',
                            'title' => 'Tahun'
                        ),
                        array(
                            'field' => 'ruta_alamat',
                            'title' => 'Alamat'
                        ),
                        array(
                            'field' => 'ruta_nama_krt',
                            'title' => 'KRT'
                        ),
                        
                    ),
                    'action'=> [
                        'detail' => [
                            'link'=> 'admin/ruta/detail/'
                        ]
                    ]
                ),
            )
            ->set_toolbar(function($toolbar){
                $toolbar
                    ->add('add', ['label'=>'Import Ruta', 'url'=> base_url("admin/ruta/import")])
                    ->addHtml('<a href="'.base_url("admin/ruta/importArt").'" class="btn btn-sm btn-warning"><i class="k-icon k-i-plus"></i> Import ART</a>');
            })
            ->output();
    }

    public function gridArt($ruta_id)
    {
        $SQL = "SELECT
                    art.*,
                    art_id as id,
                    ref_jk_label as jenis_kelamin,
                    art_tempat_lahir ||', '||to_char(art_tanggal_lahir,'DD MONTH YYYY') as ttl
                FROM
                    art
                    LEFT JOIN ruta ON ruta_tahun = art_tahun 
                    AND ruta_periode = art_periode 
                    AND ruta_id_bdt = art_bdt_id
                    left join ref_jk on ref_jk_id = art_jns_kel
                where ruta_id = ".$ruta_id;

        $grid = new Grid();
        return $grid->set_query($SQL)
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/ruta/gridArt/".$ruta_id."?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'art_art_id',
                            'title' => 'ARTID',
                        ),
                        array(
                            'field' => 'art_nama',
                            'title' => 'Nama'
                        ),
                        array(
                            'field' => 'jenis_kelamin',
                            'title' => 'Jenis Kelamin'
                        ),
                        array(
                            'field' => 'art_no_pkh',
                            'title' => 'No PKH'
                        ),
                        array(
                            'field' => 'ttl',
                            'title' => 'TTL'
                        ),
                        
                    ),
                    'action'=> [
                        'detail' => [
                            'jsf'=> 'detailArt'
                        ]
                    ]
                ),
            )
            ->output();
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('ruta_id_bdt', 'IDBDT', 'text', false, $this->request->getGet('ruta_id_bdt'), 'style="width:100%;" ')
            ->add('ruta_nama_krt', 'KRT', 'text', false, $this->request->getGet('ruta_nama_krt'), 'style="width:100%;" ')
            ->add('ruta_alamat', 'Alamat', 'text', false, $this->request->getGet('ruta_alamat'), 'style="width:100%;" ')
            ->output();
    }

    public function import()
    {
        $data['title']  = 'Import Ruta';
        $data['form']   = $this->form();
        $data['url_back']= base_url("admin/ruta");
        return view('global/form', $data);
    }

    public function importArt()
    {
        $data['title']  = 'Import ART';
        $data['form']   = $this->form_art();
        $data['url_back']= base_url("admin/ruta");
        return view('global/form', $data);
    }

    public function detail($ruta_id)
    {
        $data['title']  = 'Detail Ruta ID '.$ruta_id;
        $data['form']   = $this->formDetail($ruta_id);
        $data['grid_anggota']   = $this->gridArt($ruta_id);
        $data['url_back']= base_url("admin/ruta");
        return view('admin/ruta/detail', $data);
    }

    public function formDetail($ruta_id)
    {
        $ruta = $this->db->table("ruta")->getWhere(['ruta_id'=>$ruta_id])->getRowArray();
        $form = new Form();
        return $form->set_attribute_form('class="form-horizontal"')
            ->set_resume(true)
            ->set_template_column(2)
            ->set_submit_label("Import")
            ->add('ruta_idbdt', 'IDBDT', 'text', false, $ruta['ruta_id_bdt'], 'style="width:100%;"')
            ->add('ruta_tahun', 'Tahun', 'text', false, $ruta['ruta_tahun'], 'style="width:100%;"')
            ->add('ruta_periode', 'Periode', 'select', false, $ruta['ruta_periode'], 'style="width:100%;"', [
                'table' => 'ref_periode',
                'id' => 'periode_id',
                'label' => 'periode_label'
            ])
            ->add('ruta_kd_desa', 'Desa', 'select', false, $ruta['ruta_kd_desa'], 'style="width:100%;"', [
                'table' => 'ref_desa',
                'id' => 'desa_kode',
                'label' => 'desa_label'
            ])
            ->add('ruta_kd_kec', 'Kecamatan', 'select', false, $ruta['ruta_kd_kec'], 'style="width:100%;"', [
                'table' => 'ref_kecamatan',
                'id' => 'kec_kode',
                'label' => 'kec_label'
            ])
            ->add('ruta_alamat', 'Alamat', 'text', false, $ruta['ruta_alamat'], 'style="width:100%;"')
            ->add('ruta_nama_sls', 'Nama SLS', 'text', false, $ruta['ruta_nama_sls'], 'style="width:100%;"')
            ->add('ruta_nama_krt', 'Nama Kepala Ruta', 'text', false, $ruta['ruta_nama_krt'], 'style="width:100%;"')
            ->add('ruta_jumlah_art', 'Jumlah Angota Ruta', 'text', false, $ruta['ruta_jumlah_art'], 'style="width:100%;"')
            ->add('ruta_jumlah_kk', 'Jumlah KK', 'text', false, $ruta['ruta_jumlah_kk'], 'style="width:100%;"')
            ->add('ruta_jumlah_kk', 'Jumlah KK', 'text', false, $ruta['ruta_jumlah_kk'], 'style="width:100%;"')
            ->add('ruta_sta_bangunan', 'Status Bangunan', 'select', false, $ruta['ruta_sta_bangunan'], 'style="width:100%;"', [
                'table' => 'ref_status_bangunan',
                'id' => 'ref_sta_bangunan_id',
                'label' => 'ref_sta_bangunan_label'
            ])
            ->add('ruta_luas_lantai', 'Luas Lantai', 'text', false, $ruta['ruta_luas_lantai'], 'style="width:100%;"')
            ->add('ruta_sta_lantai', 'Status Lantai', 'select', false, $ruta['ruta_sta_lantai'], 'style="width:100%;"', [
                'table' => 'ref_lantai',
                'id' => 'ref_lantai_id',
                'label' => 'ref_lantai_label'
            ])
            ->add('ruta_sta_dinding', 'Status Dinding', 'select', false, $ruta['ruta_sta_dinding'], 'style="width:100%;"', [
                'table' => 'ref_dinding',
                'id' => 'ref_dinding_id',
                'label' => 'ref_dinding_label'
            ])
            ->add('ruta_kondisi_dinding', 'Kondisi Dinding', 'select', false, $ruta['ruta_kondisi_dinding'], 'style="width:100%;"', [
                'table' => 'ref_kondisi_dinding',
                'id' => 'ref_kon_dinding_id',
                'label' => 'ref_kon_dinding_label'
            ])
            ->add('ruta_sta_atap', 'Status Atap', 'select', false, $ruta['ruta_sta_atap'], 'style="width:100%;"', [
                'table' => 'ref_atap',
                'id' => 'ref_atap_id',
                'label' => 'ref_atap_label'
            ])
            ->add('ruta_kondisi_atap', 'Kondisi Atap', 'select', false, $ruta['ruta_kondisi_atap'], 'style="width:100%;"', [
                'table' => 'ref_kondisi_atap',
                'id' => 'ref_kon_atap_id',
                'label' => 'ref_kon_atap_label'
            ])
            ->add('ruta_jumlah_kamar', 'Jumlah Kamar', 'text', false, $ruta['ruta_jumlah_kamar'], 'style="width:100%;"')
            ->add('ruta_sumber_air_minum', 'Sumber Air Minum', 'select', false, $ruta['ruta_sumber_air_minum'], 'style="width:100%;"', [
                'table' => 'ref_air_minum',
                'id' => 'ref_minum_id',
                'label' => 'ref_minum_label'
            ])
            ->add('ruta_nomor_meter_air', 'Nomor Meter Air', 'text', false, $ruta['ruta_nomor_meter_air'], 'style="width:100%;"')
            ->add('ruta_cara_peroleh_air', 'Cara Peroleh Air Minum', 'select', false, $ruta['ruta_cara_peroleh_air'], 'style="width:100%;"', [
                'table' => 'ref_peroleh_air',
                'id' => 'ref_peroleh_air_id',
                'label' => 'ref_peroleh_air_label'
            ])
            ->add('ruta_sumber_penerangan', 'Sumber Penerangan', 'select', false, $ruta['ruta_sumber_penerangan'], 'style="width:100%;"', [
                'table' => 'ref_penerangan',
                'id' => 'ref_penerangan_id',
                'label' => 'ref_penerangan_label'
            ])
            ->add('ruta_daya', 'Daya', 'select', false, $ruta['ruta_daya'], 'style="width:100%;"', [
                'table' => 'ref_listrik',
                'id' => 'ref_listrik_id',
                'label' => 'ref_listrik_label'
            ])
            ->add('ruta_nomor_pln', 'Nomor PLN', 'text', false, $ruta['ruta_nomor_pln'], 'style="width:100%;"')
            ->add('ruta_bb_masak', 'Bahan Bakar Masak', 'select', false, $ruta['ruta_bb_masak'], 'style="width:100%;"', [
                'table' => 'ref_bahan_bakar',
                'id' => 'ref_bb_id',
                'label' => 'ref_bb_label'
            ])
            ->add('ruta_nomor_gas', 'Bahan Bakar Masak', 'text', false, $ruta['ruta_nomor_gas'], 'style="width:100%;"')
            ->add('ruta_fas_bab', 'Fasilitas BAB', 'select', false, $ruta['ruta_fas_bab'], 'style="width:100%;"', [
                'table' => 'ref_bab',
                'id' => 'ref_bab_id',
                'label' => 'ref_bab_label'
            ])
            ->add('ruta_kloset', 'Kloset', 'select', false, $ruta['ruta_kloset'], 'style="width:100%;"', [
                'table' => 'ref_kloset',
                'id' => 'ref_kloset_id',
                'label' => 'ref_kloset_label'
            ])
            ->add('ruta_buang_tinja', 'Buang Tinja', 'select', false, $ruta['ruta_buang_tinja'], 'style="width:100%;"', [
                'table' => 'ref_tinja',
                'id' => 'ref_tinja_id',
                'label' => 'ref_tinja_label'
            ])
            ->add('ruta_ada_tabung_gas', 'Ada Tabung Gas ?', 'select', false, $ruta['ruta_ada_tabung_gas'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_lemari_es', 'Ada Lemari Es ?', 'select', false, $ruta['ruta_ada_lemari_es'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_ac', 'Ada AC ?', 'select', false, $ruta['ruta_ada_ac'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_pemanas', 'Ada Pemanas ?', 'select', false, $ruta['ruta_ada_pemanas'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_telepon', 'Ada Telepon ?', 'select', false, $ruta['ruta_ada_telepon'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_telepon', 'Ada Telepon ?', 'select', false, $ruta['ruta_ada_telepon'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_emas', 'Ada Emas ?', 'select', false, $ruta['ruta_ada_emas'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_laptop', 'Ada Laptop ?', 'select', false, $ruta['ruta_ada_laptop'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_sepeda', 'Ada Sepeda ?', 'select', false, $ruta['ruta_ada_sepeda'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_motor', 'Ada Motor ?', 'select', false, $ruta['ruta_ada_motor'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_mobil', 'Ada Mobil ?', 'select', false, $ruta['ruta_ada_mobil'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_mobil', 'Ada Mobil ?', 'select', false, $ruta['ruta_ada_mobil'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_tempel', 'Ada Tempel ?', 'select', false, $ruta['ruta_ada_tempel'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_perahu_motor', 'Ada Perahu Motor ?', 'select', false, $ruta['ruta_ada_perahu_motor'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_ada_kapal', 'Ada Kapal ?', 'select', false, $ruta['ruta_ada_kapal'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('ruta_aset_tak_bergerak', 'Aset tak bergerak', 'text', false, $ruta['ruta_aset_tak_bergerak'], 'style="width:100%;"')
            ->add('ruta_luas_atb', 'Luas ATB', 'text', false, $ruta['ruta_luas_atb'], 'style="width:100%;"')
            ->add('ruta_rumah_lain', 'Rumah Lain', 'text', false, $ruta['ruta_rumah_lain'], 'style="width:100%;"')
            ->add('ruta_jumlah_sapi', 'Jumlah Sapi', 'text', false, $ruta['ruta_jumlah_sapi'], 'style="width:100%;"')
            ->add('ruta_jumlah_kerbau', 'Jumlah Kerbau', 'text', false, $ruta['ruta_jumlah_kerbau'], 'style="width:100%;"')
            ->add('ruta_jumlah_kuda', 'Jumlah Kuda', 'text', false, $ruta['ruta_jumlah_kuda'], 'style="width:100%;"')
            ->add('ruta_jumlah_babi', 'Jumlah Babi', 'text', false, $ruta['ruta_jumlah_babi'], 'style="width:100%;"')
            ->add('ruta_jumlah_kambing', 'Jumlah Kambing', 'text', false, $ruta['ruta_jumlah_kambing'], 'style="width:100%;"')
            ->add('ruta_sta_art_usaha', 'Status ART Usaha', 'text', false, $ruta['ruta_sta_art_usaha'], 'style="width:100%;"')
            ->add('ruta_sta_keberadaan_rt', 'Keberadaan RT', 'select', false, $ruta['ruta_sta_keberadaan_rt'], 'style="width:100%;"',[
                'table' => 'ref_rt',
                'id' => 'ref_rt_id',
                'label' => 'ref_rt_label'
            ])
            ->add('ruta_percentile', 'Percentile', 'text', false, $ruta['ruta_percentile'], 'style="width:100%;"')
            ->add('ruta_sta_kesejahteraan', 'Status Kesejahteraan', 'select', false, $ruta['ruta_sta_kesejahteraan'], 'style="width:100%;"',[
                'table' => 'ref_kesejahteraan',
                'id' => 'ref_kesejahteraan_id',
                'label' => 'ref_kesejahteraan_label'
            ])
            ->output();
    }

    public function form()
    {
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"  enctype="multipart/form-data"')
            ->set_submit_label("Import")
            ->add('file', 'File Excel', 'file', false, '', 'style="width:100%;"')
            ->add('tahun', 'Tahun', 'number', true, '', ' style="width:100%;"')
            ->add('periode', 'Periode', 'select', true, '', ' style="width:100%;"', array(
                'table' => 'ref_periode',
                'id' => 'periode_id',
                'label' => 'periode_label',
            ));
        if ($form->formVerified()) {
            $file = $this->request->getFile('file');
            $name = $file->getRandomName();
            if ($file->move('./uploads/', $name)) {
                $dataForm['import_file'] = $name;
                $dataForm['import_finish'] = false;
                $dataForm['import_at'] = date("Y-m-d H:i:s");
                $dataForm['import_by'] = $this->user['user_id'];
                $dataForm['import_tahun'] = $this->request->getPost('tahun');
                $dataForm['import_periode'] = $this->request->getPost('periode');
                $dataForm['import_jenis'] = 1;
                
                $this->db->table("import")->insert($dataForm);
                $id = $this->db->insertID();
                pclose(popen('start /B cmd /C "php \xampp7\htdocs\apps\sidamis\public\index.php import ruta '.$id.'"','r'));
            }
            die(forceRedirect(base_url('/admin/ruta')));
        } else {
            return $form->output();
        }
    }

    function form_art(){
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"  enctype="multipart/form-data"')
            ->set_submit_label("Import")
            ->add('file', 'File Excel', 'file', false, '', 'style="width:100%;"')
            ->add('tahun', 'Tahun', 'number', true, '', ' style="width:100%;"')
            ->add('periode', 'Periode', 'select', true, '', ' style="width:100%;"', array(
                'table' => 'ref_periode',
                'id' => 'periode_id',
                'label' => 'periode_label',
            ));
        if ($form->formVerified()) {
            $file = $this->request->getFile('file');
            $name = $file->getRandomName();
            if ($file->move('./uploads/', $name)) {
                $dataForm['import_file'] = $name;
                $dataForm['import_finish'] = false;
                $dataForm['import_at'] = date("Y-m-d H:i:s");
                $dataForm['import_by'] = $this->user['user_id'];
                $dataForm['import_tahun'] = $this->request->getPost('tahun');
                $dataForm['import_periode'] = $this->request->getPost('periode');
                $dataForm['import_jenis'] = 2;
                
                $this->db->table("import")->insert($dataForm);
                $id = $this->db->insertID();
                pclose(popen('start /B cmd /C "php \xampp7\htdocs\apps\sidamis\public\index.php import art '.$id.'"','r'));
            }
            die(forceRedirect(base_url('/admin/ruta')));
        } else {
            return $form->output();
        }
    }

    public function detailArt($art_id)
    {
        $data['title']  = 'Detail ART ID '.$art_id;
        $data['form']   = $this->formDetailArt($art_id);
        return view('admin/ruta/detailArt', $data);
    }

    public function formDetailArt($art_id)
    {
        $art = $this->db->table("art")->getWhere(['art_id'=>$art_id])->getRowArray();
        $form = new Form();
        return $form->set_attribute_form('class="form-horizontal"')
            ->set_resume(true)
            ->set_template_column(2)
            ->set_submit_label("Import")
            ->add('ruta_idbdt', 'IDBDT', 'text', false, $art['art_id'], 'style="width:100%;"')
            
            ->output();
    }
}