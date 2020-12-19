<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Import extends BaseController
{
    public function ruta($id)
    {
        $this->db->table("import")->where(["import_id" => $id])->update([
            'import_execute' => true
        ]);
        echo "Running\n";
        $import = $this->db->table("import")->getWhere(["import_id" => $id])->getRowArray();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('./uploads/' . $import['import_file']);
        $xls_data = $spreadsheet->getSheet(0)->toArray();
        $dataInsert = array();
        for ($i = 1; $i <= 30000; $i++) {
            if (isset($xls_data[$i])) {
                $dataInsert = array(
                    'ruta_tahun' => $import['import_tahun'],
                    'ruta_periode' => (int) $import['import_periode'],
                    'ruta_id_bdt' => (int) $xls_data[$i][0],
                    'ruta_kd_prop' => (int)  $xls_data[$i][1],
                    'ruta_kd_kab' => (int)  $xls_data[$i][2],
                    'ruta_kd_kec' => (int)  $xls_data[$i][3],
                    'ruta_kd_desa' => (int)  $xls_data[$i][4],
                    'ruta_alamat' => $xls_data[$i][7],
                    'ruta_nama_sls' => $xls_data[$i][8],
                    'ruta_nama_krt' => $xls_data[$i][9],
                    'ruta_jumlah_art' => (int)  $xls_data[$i][10],
                    'ruta_jumlah_kk' => (int)  $xls_data[$i][11],
                    'ruta_sta_bangunan' => (int)  $xls_data[$i][12],
                    'ruta_sta_lahan' => (int)  $xls_data[$i][13],
                    'ruta_luas_lantai' => (int)  $xls_data[$i][14],
                    'ruta_sta_lantai' => (int)  $xls_data[$i][15],
                    'ruta_sta_dinding' => (int)  $xls_data[$i][16],
                    'ruta_kondisi_dinding' => (int)  $xls_data[$i][17],
                    'ruta_sta_atap' => (int)  $xls_data[$i][18],
                    'ruta_kondisi_atap' => (int)  $xls_data[$i][19],
                    'ruta_jumlah_kamar' => (int)  $xls_data[$i][20],
                    'ruta_sumber_air_minum' => (int)  $xls_data[$i][21],
                    'ruta_nomor_meter_air' => $xls_data[$i][22],
                    'ruta_cara_peroleh_air' => (int)  $xls_data[$i][23],
                    'ruta_sumber_penerangan' => (int)  $xls_data[$i][24],
                    'ruta_daya' => (int)  $xls_data[$i][25],
                    'ruta_nomor_pln' => $xls_data[$i][26],
                    'ruta_bb_masak' => (int) $xls_data[$i][27],
                    'ruta_nomor_gas' => (int)  $xls_data[$i][28],
                    'ruta_fas_bab' => (int)  $xls_data[$i][29],
                    'ruta_kloset' => (int)  $xls_data[$i][30],
                    'ruta_buang_tinja' => (int)  $xls_data[$i][31],
                    'ruta_ada_tabung_gas' => (int)  $xls_data[$i][32],
                    'ruta_ada_lemari_es' => (int)  $xls_data[$i][33],
                    'ruta_ada_ac' => (int)  $xls_data[$i][34],
                    'ruta_ada_pemanas' => (int)  $xls_data[$i][35],
                    'ruta_ada_telepon' => (int)  $xls_data[$i][36],
                    'ruta_ada_tv' => (int)  $xls_data[$i][37],
                    'ruta_ada_emas' => (int)  $xls_data[$i][38],
                    'ruta_ada_laptop' => (int)  $xls_data[$i][39],
                    'ruta_ada_sepeda' => (int)  $xls_data[$i][40],
                    'ruta_ada_motor' => (int)  $xls_data[$i][41],
                    'ruta_ada_mobil' => (int)  $xls_data[$i][42],
                    'ruta_ada_perahu' => (int)  $xls_data[$i][43],
                    'ruta_ada_tempel' => (int)  $xls_data[$i][44],
                    'ruta_ada_perahu_motor' => (int)  $xls_data[$i][45],
                    'ruta_ada_kapal' => (int)  $xls_data[$i][46],
                    'ruta_aset_tak_bergerak' => (int)  $xls_data[$i][47],
                    'ruta_luas_atb' => (int)  $xls_data[$i][48],
                    'ruta_rumah_lain' => (int)  $xls_data[$i][49],
                    'ruta_jumlah_sapi' => (int)  $xls_data[$i][50],
                    'ruta_jumlah_kerbau' => (int)  $xls_data[$i][51],
                    'ruta_jumlah_kuda' => (int)  $xls_data[$i][52],
                    'ruta_jumlah_babi' => (int)  $xls_data[$i][53],
                    'ruta_jumlah_kambing' => (int)  $xls_data[$i][54],
                    'ruta_sta_art_usaha' => (int)  $xls_data[$i][55],
                    'ruta_sta_keberadaan_rt' => (int)  $xls_data[$i][56],
                    'ruta_percentile' => (int)  $xls_data[$i][57],
                    'ruta_sta_kesejahteraan' => (int)  $xls_data[$i][58]
                );
                try {
                    $proses_insert = $this->db->table("ruta")->insert($dataInsert);
                } catch (\Exception $e) {
                    $this->db->table("import")->where(['import_id'=> $id])->update([
                        'import_keterangan_error'=> $e->getMessage(),
                        'import_last_query_error'=> $this->db->getLastQuery(),
                        'import_last_line_error'=> $i
                    ]);
                    break;
                }
            }
        }
        $this->db->table("import")->where(["import_id" => $id])->update([
            'import_finish' => true
        ]);
        die("Finish");
    }

    public function art($id)
    {
        $this->db->table("import")->where(["import_id" => $id])->update([
            'import_execute' => true
        ]);
        echo "Running\n";
        $import = $this->db->table("import")->getWhere(["import_id" => $id])->getRowArray();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('./uploads/' . $import['import_file']);
        $xls_data = $spreadsheet->getSheet(0)->toArray();
        $dataInsert = array();
        for ($i = 1; $i <= 30000; $i++) {
            if (isset($xls_data[$i])) {
                $dataInsert = array(
                    'art_tahun' => $import['import_tahun'],
                    'art_periode' => (int) $import['import_periode'],
                    'art_bdt_id' => (int) $xls_data[$i][0],
                    'art_art_id' => (int) $xls_data[$i][1],
                    'art_no_pkh' => $xls_data[$i][6],
                    'art_nama' => $xls_data[$i][7],
                    'art_jns_kel' => (int) $xls_data[$i][8],
                    'art_tempat_lahir' => $xls_data[$i][9],
                    'art_tanggal_lahir' => ($xls_data[$i][10] == 'NULL' ? NULL : $xls_data[$i][10]),
                    'art_nik' => $xls_data[$i][12],
                    'art_no_kk' => $xls_data[$i][13],
                    'art_hub_krt' => (int) $xls_data[$i][14],
                    'art_nuk' => (int) $xls_data[$i][15],
                    'art_hub_kel' => (int) $xls_data[$i][16],
                    'art_umur' => (int) $xls_data[$i][17],
                    'art_sta_kawin' => (int) $xls_data[$i][18],
                    'art_ada_akta_nikah' => (int) $xls_data[$i][19],
                    'art_ada_dikk' => (int) $xls_data[$i][20],
                    'art_ada_kartu_iden' => (int) $xls_data[$i][21],
                    'art_sta_hamil' => (int) $xls_data[$i][22],
                    'art_jns_cacat' => (int) $xls_data[$i][23],
                    'art_penyakit_kronis' => (int) $xls_data[$i][24],
                    'art_partisipasi_skl' => (int) $xls_data[$i][25],
                    'art_pendidikan_tertinggi' => (int) $xls_data[$i][26],
                    'art_kelas_tertinggi' =>  (int) $xls_data[$i][27],
                    'art_ijazah_tertinggi' => (int) $xls_data[$i][28],
                    'art_sta_bekerja' => (int) $xls_data[$i][29],
                    'art_jumlah_jam_kerja' => (int) $xls_data[$i][30],
                    'art_lapangan_usaha' => (int) $xls_data[$i][31],
                    'art_status_pekerjaan' => (int) $xls_data[$i][32],
                    'art_status_keberadaan_art' => (int) $xls_data[$i][33],
                    'art_status_kepesertaan_pbi' => (int) $xls_data[$i][34],
                    'art_ada_kks' => (int) $xls_data[$i][35],
                    'art_ada_pbi' => (int) $xls_data[$i][36],
                    'art_ada_kip' => (int) $xls_data[$i][37],
                    'art_ada_pkh' => (int) $xls_data[$i][38],
                    'art_ada_bpnt' => (int) $xls_data[$i][39],
                    'art_anak_diluar_rt' => (int) $xls_data[$i][40],
                    'art_nama_gadis_ibu' => $xls_data[$i][41],
                );
                try {
                    $proses_insert = $this->db->table("art")->insert($dataInsert);
                } catch (\Exception $e) {
                    $this->db->table("import")->where(['import_id'=> $id])->update([
                        'import_keterangan_error'=> $e->getMessage(),
                        'import_last_query_error'=> $this->db->getLastQuery(),
                        'import_last_line_error'=> $i
                    ]);
                    break;
                }
            }
        }
        $this->db->table("import")->where(["import_id" => $id])->update([
            'import_finish' => true
        ]);
        die("Finish");
    }
}
