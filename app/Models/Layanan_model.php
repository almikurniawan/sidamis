<?php namespace App\Models;

use CodeIgniter\Model;

class Layanan_model extends Model
{

    public function search($search)
    {
        $builder = $this->db->table('layanan');
        $builder->select('*');
        $builder->like('layanan_nama', $search);
        return $builder->get();
    }
    public function get()
    {
        $builder = $this->db->table('layanan');
        $builder->select('*');
        return $builder->get();
    }

    public function detail($layanan_id)
    {
        $builder = $this->db->table('layanan');
        $builder->select('*');
        $builder->where('layanan_id =', $layanan_id);
        return $builder->get();
    }

    public function layanan_random()
    {
        $result = $this->db->query("SELECT * FROM layanan order by random() LIMIT 7");
        return $result;
    }
 }
