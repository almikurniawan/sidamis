<?php namespace App\Models;

use CodeIgniter\Model;

class Gallery_model extends Model
{

    public function get()
    {
        $builder = $this->db->table('gallery');
        $builder->select('*');
        $builder->join('gallery_kategori', 'gallery_kategori.gallery_kategori_id = gallery.kategori_id', 'LEFT');
        return $builder->get();
    }

    public function get_kategori()
    {
        $builder = $this->db->table('gallery_kategori');
        $builder->select('*');
        return $builder->get();
    }

    public function detail($gallery_id)
    {
        $builder = $this->db->table('gallery');
        $builder->select('*');
        $builder->join('gallery_kategori', 'gallery_kategori.gallery_kategori_id = gallery.kategori_id', 'LEFT');
        $builder->where('gallery_id =', $gallery_id);
        return $builder->get();
    }

    public function gallery_random()
    {
        $result = $this->db->query("SELECT * FROM gallery order by random() LIMIT 7");
        return $result;
    }
 }
