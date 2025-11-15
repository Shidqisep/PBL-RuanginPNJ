<?php

class Admin extends Controller {
    public function index(){
        if (!isset($_SESSION['user'])){
            header('Location: /auth/formLogin');
            exit;
        }

        if ($_SESSION['role'] !== 'admin' and $_SESSION['role'] !== 'superadmin'){ 
            Flasher::setFlash('Akses ditolak', 'Anda bukan admin', 'danger');
            header('Location: /dashboard');
            exit;
        }

        $data['judul'] = 'Dashboard Admin';
        $data['navbar'] = 'dashboard';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/index');

    }
    
    public function Anggota(){
        $data['judul'] = 'Data Anggota';
        $data['navbar'] = 'Anggota';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/Anggota/index');
    }

    public function detailAnggota(){
        $data['judul'] = 'Detail Anggota';
        $data['navbar'] = 'Anggota';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/Anggota/detail');
    }

    public function Selesaikan(){
        $data['judul'] = 'Selesaikan Peminjaman';
        $data['navbar'] = 'Anggota';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/Anggota/selesaikan');
    }

    public function Ruangan(){
        $data['judul'] = 'Data Ruangan';
        $data['navbar'] = 'Ruangan';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/ruangan');
    }

    public function Akun(){
        $data['judul'] = 'Profile Admin';
        $data['navbar'] = 'Akun';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/akun');
    }

}