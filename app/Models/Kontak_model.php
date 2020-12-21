<?php namespace App\Models;

use CodeIgniter\Model;

class Kontak_model extends Model
{

    public function get()
    {
        $builder = $this->db->table('kontak');
        $builder->select('*');
        return $builder->get();
    }

    public function kirim_pesan($data){
        $query = $this->db->table('kontak')->insert($data);
        return $query;
    }

    public function kontak_random()
    {
        $result = $this->db->query("SELECT * FROM kontak order by random() LIMIT 7");
        return $result;
    }
 }
