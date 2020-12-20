<?php namespace App\Models;

use CodeIgniter\Model;

class Tentang_model extends Model
{

    public function get($tipe)
    {
        $builder = $this->db->table('tentang');
        $builder->select('*');
        $builder->where('tentang_tipe', $tipe);
        return $builder->get();
    }

    public function tentang_random()
    {
        $result = $this->db->query("SELECT * FROM tentang order by random() LIMIT 7");
        return $result;
    }
 }
