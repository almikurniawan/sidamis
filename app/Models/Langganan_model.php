<?php namespace App\Models;

use CodeIgniter\Model;

class Langganan_model extends Model
{

    public function savelangganan($data){
        $query = $this->db->table('langganan')->insert($data);
        return $query;
    }

 }
