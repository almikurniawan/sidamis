<?php namespace App\Models;

use CodeIgniter\Model;

class Berita_model extends Model
{

    public function get()
    {
        $builder = $this->db->table('berita');
        $builder->select('*');
        return $builder->get();
    }

    public function detail($berita_id)
    {
        $builder = $this->db->table('berita');
        $builder->select('*');
        $builder->where('berita_id =', $berita_id);
        return $builder->get();
    }

    public function berita_random()
    {
        $result = $this->db->query("SELECT * FROM berita order by random() LIMIT 7");
        return $result;
    }
 }
