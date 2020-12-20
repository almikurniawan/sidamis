<?php namespace App\Models;

use CodeIgniter\Model;

class Informasi_model extends Model
{

    public function get()
    {
        $builder = $this->db->table('Informasi');
        $builder->select('*');
        return $builder->get();
    }

    public function detail($Informasi_id)
    {
        $builder = $this->db->table('Informasi');
        $builder->select('*');
        $builder->where('Informasi_id =', $Informasi_id);
        return $builder->get();
    }

    public function Informasi_random()
    {
        $result = $this->db->query("SELECT * FROM Informasi order by random() LIMIT 7");
        return $result;
    }
 }
