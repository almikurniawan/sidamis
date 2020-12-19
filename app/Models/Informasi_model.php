<?php namespace App\Models;

use CodeIgniter\Model;

class Informasi_model extends Model
{

    public function get()
    {
        $builder = $this->db->table('informasi');
        $builder->select('*');
        return $builder->get();
    }

    public function detail($informasi_id)
    {
        $builder = $this->db->table('informasi');
        $builder->select('*');
        $builder->where('informasi_id =', $informasi_id);
        return $builder->get();
    }

    public function informasi_random()
    {
        $result = $this->db->query("SELECT * FROM informasi order by random() LIMIT 7");
        return $result;
    }
 }
