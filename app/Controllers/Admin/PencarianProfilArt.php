<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class PencarianProfilArt extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Pencarian Profile ART';
        $data['url_delete']  = '';
        
        return view('global/list', $data);
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('ruta_kd_kec', 'Kecamatan', 'select', false, $this->request->getGet('ruta_kd_kec'), 'style="width:100%;" ', [
                'table' => 'ref_kecamatan',
                'id' => 'kec_kode',
                'label' => 'kec_label'
            ])
            ->add('ruta_kd_desa', 'Desa', 'select_rbi', false, $this->request->getGet('ruta_kd_desa'), 'style="width:100%;" ', [
                'url' => base_url('admin/pencarianProfilArt/getDesa'),
                'cascade' => ['ruta_kd_kec'],
            ])
            ->add('art_jns_cacat', 'Disabilitas', 'select', false, $this->request->getGet('art_jns_cacat'), 'style="width:100%;" ', [
                'table' => 'ref_cacat',
                'id' => 'ref_cacat_id',
                'label' => 'ref_cacat_label'
            ])
            ->add('art_sta_bekerja', 'Pekerjaan', 'select', false, $this->request->getGet('art_sta_bekerja'), 'style="width:100%;" ', [
                'table' => 'ref_pekerjaan',
                'id' => 'pekerjaan_id',
                'label' => 'pekerjaan_label'
            ])
            ->add('art_pendidikan_tertinggi', 'Pendidikan', 'select', false, $this->request->getGet('art_pendidikan_tertinggi'), 'style="width:100%;" ', [
                'table' => 'ref_pendidikan',
                'id' => 'ref_pend_id',
                'label' => 'ref_pend_label'
            ])
            ->add('art_penyakit_kronis', 'Penyakit Kronis', 'select', false, $this->request->getGet('art_penyakit_kronis'), 'style="width:100%;" ', [
                'table' => 'ref_penyakit',
                'id' => 'penyakit_id',
                'label' => 'penyakit_label'
            ])
            ->add('art_umur', 'Umur', 'number', false, $this->request->getGet('art_umur'), 'style="width:100%;" ')
            ->output();
    }

    public function getDesa()
    {
        $filter = $this->request->getGet('filter');
        $ruta_kd_kec = $this->request->getGet('ruta_kd_kec');
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

    public function grid()
    {
        $SQL = "SELECT
                    art_id as id,
                    art_tahun||' - '||periode_label as periode,
                    *
                from art
                LEFT JOIN ruta ON ruta_tahun = art_tahun 
                    AND ruta_periode = art_periode 
                    AND ruta_id_bdt = art_bdt_id
                LEFT JOIN ref_periode on periode_id = art_periode";

        $grid = new Grid();
        return $grid->set_query($SQL,[
                ['art_jns_cacat' , $this->request->getGet('art_jns_cacat'),'='],
                ['art_sta_bekerja' , $this->request->getGet('art_sta_bekerja'),'='],
                ['art_pendidikan_tertinggi' , $this->request->getGet('art_pendidikan_tertinggi'),'='],
                ['art_penyakit_kronis' , $this->request->getGet('art_penyakit_kronis'),'='],
                ['art_umur' , $this->request->getGet('art_umur'),'='],
                ['ruta_kd_kec' , $this->request->getGet('ruta_kd_kec'),'='],
                ['ruta_kd_desa' , $this->request->getGet('ruta_kd_desa'),'='],
            ])
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/pencarianProfilArt/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ruta_id_bdt',
                            'title' => 'IDBDT'
                        ),
                        array(
                            'field' => 'periode',
                            'title' => 'Periode'
                        ),
                        array(
                            'field' => 'art_nama',
                            'title' => 'Nama'
                        ),
                        array(
                            'field' => 'art_nik',
                            'title' => 'NIK'
                        ),
                        array(
                            'field' => 'art_no_kk',
                            'title' => 'No KK'
                        ),
                        array(
                            'field' => 'art_umur',
                            'title' => 'Umur'
                        ),
                        
                    ),
                    'action'=> [
                        'detail' => [
                            'link'=> 'admin/pencarianProfilArt/detail/'
                        ]
                    ]
                ),
            )
            ->set_toolbar(function ($toolbar)
            {
                $toolbar->add('download');
            })
            ->output();
    }

    public function detail($art_id)
    {
        $data['title']  = 'Detail ART ID '.$art_id;
        $data['form']   = $this->formDetailArt($art_id);
        $data['url_back'] = base_url("admin/pencarianProfilArt");
        return view('admin/pencarianProfil/detailArt', $data);
    }

    public function formDetailArt($art_id)
    {
        $art = $this->db->table("art")->join('ruta', 'ruta_tahun = art_tahun AND ruta_periode = art_periode AND ruta_id_bdt = art_bdt_id')->getWhere(['art_id'=>$art_id])->getRowArray();
        $form = new Form();
        return $form
            ->set_resume(true)
            ->set_template_column(2)
            ->add('ruta_id_bdt', 'IDBDT', 'text', false, $art['ruta_id_bdt'], 'style="width:100%;"')
            ->add('art_art_id', 'IDART', 'text', false, $art['art_art_id'], 'style="width:100%;"')
            ->add('ruta_kd_desa', 'Desa', 'select', false, $art['ruta_kd_desa'], 'style="width:100%;"', [
                'table' => 'ref_desa',
                'id' => 'desa_kode',
                'label' => 'desa_label'
            ])
            ->add('ruta_kd_kec', 'Kecamatan', 'select', false, $art['ruta_kd_kec'], 'style="width:100%;"', [
                'table' => 'ref_kecamatan',
                'id' => 'kec_kode',
                'label' => 'kec_label'
            ])
            ->add('art_no_pkh', 'No PKH', 'text', false, $art['art_no_pkh'], 'style="width:100%;"')
            ->add('art_nama', 'Nama', 'text', false, $art['art_nama'], 'style="width:100%;"')
            ->add('art_jns_kel', 'Jenis Kelamin', 'select', false, $art['art_jns_kel'], 'style="width:100%;"', [
                'table' => 'ref_jk',
                'id' => 'ref_jk_id',
                'label' => 'ref_jk_label'
            ])
            ->add('art_tempat_lahir', 'Tempat Lahir', 'text', false, $art['art_tempat_lahir'], 'style="width:100%;"')
            ->add('art_tanggal_lahir', 'Tanggal Lahir', 'date', false, $art['art_tanggal_lahir'], 'style="width:100%;"')
            ->add('art_nik', 'NIK', 'text', false, $art['art_nik'], 'style="width:100%;"')
            ->add('art_no_kk', 'KK', 'text', false, $art['art_no_kk'], 'style="width:100%;"')
            ->add('art_hub_krt', 'Hubungan Kepala Rumah Tangga', 'select', false, $art['art_hub_krt'], 'style="width:100%;"', [
                'table' => 'ref_hubungan_krt',
                'id' => 'ref_hub_id',
                'label' => 'ref_hub_label'
            ])
            ->add('art_nuk', 'NUK', 'text', false, $art['art_nuk'], 'style="width:100%;"')
            ->add('art_hub_kel', 'Hubungan Keluarga', 'select', false, $art['art_hub_kel'], 'style="width:100%;"', [
                'table' => 'ref_hubungan_krt',
                'id' => 'ref_hub_id',
                'label' => 'ref_hub_label'
            ])
            ->add('art_umur', 'Umur', 'text', false, $art['art_umur']." Tahun", 'style="width:100%;"')
            ->add('art_sta_kawin', 'Status Kawin', 'select', false, $art['art_sta_kawin'], 'style="width:100%;"', [
                'table' => 'ref_kawin',
                'id' => 'ref_kawin_id',
                'label' => 'ref_kawin_label'
            ])
            ->add('art_ada_akta_nikah', 'Ada Akta Nikah', 'select', false, $art['art_ada_akta_nikah'], 'style="width:100%;"', [
                'table' => 'ref_akta_nikah',
                'id' => 'ref_akta_nikah_id',
                'label' => 'ref_akta_nikah_label'
            ])
            ->add('art_ada_dikk', 'Ada di KK', 'select', false, $art['art_ada_dikk'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('art_ada_kartu_iden', 'Ada Kartu Identitas', 'select', false, $art['art_ada_kartu_iden'], 'style="width:100%;"', [
                'table' => 'ref_kartu_identitas',
                'id' => 'ref_kti_id',
                'label' => 'ref_kti_label'
            ])
            ->add('art_sta_hamil', 'Status Hamil', 'select', false, $art['art_sta_hamil'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('art_jns_cacat', 'Jenis Cacat', 'select', false, $art['art_jns_cacat'], 'style="width:100%;"', [
                'table' => 'ref_cacat',
                'id' => 'ref_cacat_id',
                'label' => 'ref_cacat_label'
            ])
            ->add('art_penyakit_kronis', 'Penyakit Kronis', 'select', false, $art['art_penyakit_kronis'], 'style="width:100%;"', [
                'table' => 'ref_penyakit',
                'id' => 'penyakit_id',
                'label' => 'penyakit_label'
            ])
            ->add('art_partisipasi_skl', 'Partisipasi Sekolah', 'select', false, $art['art_partisipasi_skl'], 'style="width:100%;"', [
                'table' => 'ref_sekolah',
                'id' => 'ref_sek_id',
                'label' => 'ref_sek_label'
            ])
            ->add('art_pendidikan_tertinggi', 'Pendidikan Tertinggi', 'select', false, $art['art_pendidikan_tertinggi'], 'style="width:100%;"', [
                'table' => 'ref_pendidikan',
                'id' => 'ref_pend_id',
                'label' => 'ref_pend_label'
            ])
            ->add('art_kelas_tertinggi', 'Kelas Tertinggi', 'select', false, $art['art_kelas_tertinggi'], 'style="width:100%;"', [
                'table' => 'ref_kelas',
                'id' => 'ref_kelas_id',
                'label' => 'ref_kelas_label'
            ])
            ->add('art_ijazah_tertinggi', 'Ijazah Tertinggi', 'select', false, $art['art_ijazah_tertinggi'], 'style="width:100%;"', [
                'table' => 'ref_ijazah',
                'id' => 'ref_ijazah_id',
                'label' => 'ref_ijazah_label'
            ])
            ->add('art_sta_bekerja', 'Status Bekerja', 'select', false, $art['art_sta_bekerja'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('art_jumlah_jam_kerja', 'Jam Kerja', 'text', false, $art['art_jumlah_jam_kerja']." Jam per Minggu", 'style="width:100%;"')
            ->add('art_lapangan_usaha', 'Lapangan Usaha', 'select', false, $art['art_lapangan_usaha'], 'style="width:100%;"', [
                'table' => 'ref_pekerjaan',
                'id' => 'pekerjaan_id',
                'label' => 'pekerjaan_label'
            ])
            ->add('art_status_pekerjaan', 'Status Pekerjaan', 'select', false, $art['art_status_pekerjaan'], 'style="width:100%;"', [
                'table' => 'ref_status_pekerjaan',
                'id' => 'ref_status_pek_id',
                'label' => 'ref_status_pek_label'
            ])
            ->add('art_status_keberadaan_art', 'Keberadaan ART', 'select', false, $art['art_status_keberadaan_art'], 'style="width:100%;"', [
                'table' => 'ref_keberadaan_rt',
                'id' => 'ref_keberadaan_rt_id',
                'label' => 'ref_keberadaan_rt_label'
            ])
            ->add('art_ada_kks', 'Ada KKS', 'select', false, $art['art_ada_kks'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('art_ada_pbi', 'Ada PBI', 'select', false, $art['art_ada_pbi'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('art_ada_kip', 'Ada KIP', 'select', false, $art['art_ada_kip'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('art_ada_pkh', 'Ada PKH', 'select', false, $art['art_ada_pkh'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('art_ada_bpnt', 'Ada BPNT', 'select', false, $art['art_ada_bpnt'], 'style="width:100%;"', [
                'table' => 'ref_ya_tidak',
                'id' => 'ref_ya_tidak_id',
                'label' => 'ref_ya_tidak_label'
            ])
            ->add('art_anak_diluar_rt', 'Anak diluar Rumah Tangga', 'text', false, $art['art_anak_diluar_rt'], 'style="width:100%;"')
            ->add('art_nama_gadis_ibu', 'Nama Ibu', 'text', false, $art['art_nama_gadis_ibu'], 'style="width:100%;"')
            ->output();
    }
}