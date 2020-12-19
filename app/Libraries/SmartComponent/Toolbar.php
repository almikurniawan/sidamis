<?php
namespace App\Libraries\SmartComponent;

class Toolbar{
    
    protected $toolbar;
    protected $base_url;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
        $this->db = \Config\Database::connect();
    }

    public function addHtml($html)
    {
        $this->toolbar .= $html;
        return $this;
    }

    public function add($type, $config = null)
    {
        if($type=='add'){
            $label = (isset($config['label']) ? $config['label'] : 'Tambah Data');
            $class = (isset($config['class']) ? $config['class'] : 'btn btn-sm mr-1 btn-primary');
            if(!isset($config['jsf'])){
                $url = (isset($config['url']) ? $config['url'] : base_url(uri_string()) . '/add');
                $this->toolbar .= '<a class="'.$class.'" href="'.$url.'"><i class="k-icon k-i-plus"></i> '.$label.'</a>';
            }else{
                $onclick = (isset($config['jsf']) ? $config['jsf'] : 'addItem()');
                $this->toolbar .= '<a class="'.$class.'" onclick="'.$onclick.'"><i class="k-icon k-i-download"></i> '.$label.'</a>';
            }
        }else if($type=='download'){
            $label = (isset($config['label']) ? $config['label'] : 'Download Excel');
            $class = (isset($config['class']) ? $config['class'] : 'btn btn-sm mr-1 btn-success');
            if(!isset($config['jsf'])){
                $this->toolbar .= '<a target="_new" class="'.$class.'" href="'.$this->base_url.'"><i class="k-icon k-i-download"></i> '.$label.'</a>';
            }else{
                $onclick = (isset($config['jsf']) ? $config['jsf'] : 'addItem()');
                $this->toolbar .= '<a class="'.$class.'" onclick="'.$onclick.'"><i class="k-icon k-i-download"></i> '.$label.'</a>';
            }
        }

        return $this;
    }

    public function output()
    {
        return $this->toolbar;
    }
}