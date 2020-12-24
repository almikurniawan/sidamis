<?php namespace App\Models;

use CodeIgniter\Model;

class home_model extends Model
{

    public function get($tabel)
    {
        $builder = $this->db->table($tabel);
        $builder->select('*');
        return $builder->get();
    }

    public function home_random()
    {
        $result = $this->db->query("SELECT * FROM home order by random() LIMIT 7");
        return $result;
    }

    public function get_gallery()
    {
        $builder = $this->db->table('gallery');
        $builder->select('*');
        $builder->join('gallery_kategori', 'gallery_kategori.gallery_kategori_id = gallery.gallery_kategori_id', 'LEFT');
        return $builder->get();
    }

    public function get_kategori()
    {
        $builder = $this->db->table('gallery_kategori');
        $builder->select('*');
        return $builder->get();
    }
 }
