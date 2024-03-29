<?php

namespace App\Libraries;

class Navigation
{
    public function __construct()
    {
        $this->db 		= \Config\Database::connect();
        $this->session 	= \Config\Services::session();
    }

    public function menu()
    {
        $data['menu'] = $this->gen_menu();
        return view('template/menu', $data);
    }

    private function gen_menu()
    {
        $menu = '';
        $list_menu = $this->list_menu();
        foreach ($list_menu as $key => $value) {
            if($this->cek_akses($value['controller'])){
                if (isset($value['child'])) {
                    $menu .= '<li class="nav-item dropdown"><a class="nav-link pl-0 dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="' . $value['icon'] . '"></i> ' . $value['label'] . ' </a><div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    foreach ($value['child'] as $k => $v) {
                        $menu .= '<a class="dropdown-item" href="' . base_url($v['controller']) . '">' . $v['label'] . ' </a>';
                    }
                    $menu .= '</div></li>';
                } else {
                    $menu .= '<li class="nav-item"><a class="nav-link pl-0" href="' . base_url($value['controller']) . '"><i class="' . $value['icon'] . '"></i> ' . $value['label'] . ' </a></li>';
                }
            }
        }
        // $menu .= '<li><a class="nav-link pl-0" href="' . base_url("login/logout") . '"><i class="k-icon k-i-logout"></i> Logout </a></li>';

        return $menu;
    }

    public function cek_akses($controller)
    {
        return true;
        $data_ref_modul = $this->db->query("SELECT
                                            ref_modul_akses_label
                                        FROM
                                            ref_modul_akses
                                        WHERE
                                            lower(ref_modul_akses_label) = '".trim(strtolower($controller))."'")->getRowArray();
        if(!empty($data_ref_modul)){
            $user   = $this->session->get('user');
            $data_modul = $this->db->query("SELECT
                                                ref_modul_akses_label
                                            FROM
                                                ref_modul_akses
                                            WHERE
                                                ref_modul_akses_group_id IN (
                                            SELECT
                                                ref_user_akses_group_id
                                            FROM
                                                ref_user_akses
                                            WHERE
                                                ref_user_akses_user_id = ".$user['user_id'].")
                                                and lower(ref_modul_akses_label) = '".trim(strtolower($controller))."'")->getRowArray();
            if(!empty($data_modul)){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    private function list_menu()
    {
        $list_menu = array(
            array(
                'label'         => 'RUTA',
                'controller'    => 'admin/ruta',
                'icon'          => 'fa-home',
            ),
            array(
                'label'         => 'Pencarian Profil',
                'controller'    => '#pencarian_profil',
                'icon'          => 'fa-home',
                'child'         => array(
                    array(
                        'label'         => 'Pencarian Profil RUTA',
                        'controller'    => 'admin/pencarianProfilRuta',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Pencarian Profil ART',
                        'controller'    => 'admin/pencarianProfilArt',
                        'icon'          => 'fa-home',
                    ),
                )
            ),
            array(
                'label'         => 'History Import',
                'controller'    => 'admin/historyImport',
                'icon'          => 'fa-home',
            ),
            array(
                'label'         => 'Data Site',
                'controller'    => '#master',
                'icon'          => 'fa-home',
                'child'         => array(
                    array(
                        'label'         => 'Slide',
                        'controller'    => 'admin/slide',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Tentang',
                        'controller'    => 'admin/tentang',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Berita',
                        'controller'    => 'admin/berita',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Layanan',
                        'controller'    => 'admin/layanan',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Informasi',
                        'controller'    => 'admin/informasi',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Gallery',
                        'controller'    => 'admin/gallery',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Dinas terkait',
                        'controller'    => 'admin/dinas',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Kontak',
                        'controller'    => 'admin/kontak',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'         => 'Langganan',
                        'controller'    => 'admin/langganan',
                        'icon'          => 'fa-home',
                    ),
                )
            ),
            array(
                'label'         => 'Data Master',
                'controller'    => '#master',
                'icon'          => 'fa-home',
                'child'         => array(
                    array(
                        'label'     => 'Import Ruta',
                        'controller' => 'admin/importRuta',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'     => 'Import Art',
                        'controller' => 'admin/importArt',
                        'icon'          => 'fa-home',
                    ),
                    array(
                        'label'     => 'Karyawan',
                        'controller' => 'admin/karyawan',
                        'icon'          => 'fa-home',
                    ),
                )
            ),
            array(
                'label'         => 'Hak Akses',
                'controller'    => '#akses',
                'icon'          => 'fa-home',
                'child'         => array(
                    array(
                        'label'     => 'Group Akses',
                        'controller' => 'admin/aksesGroup',
                    ),
                    array(
                        'label'     => 'Modul Akses',
                        'controller' => 'admin/aksesModul',
                    ),
                    array(
                        'label'     => 'User Akses',
                        'controller' => 'admin/aksesUser',
                    ),
                )
            ),
        );

        return $list_menu;
    }
}
