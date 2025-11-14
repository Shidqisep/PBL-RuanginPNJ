<?php

class Admin extends Controller {
    public function index(){
        if (!isset($_SESSION['user_id'])){
            header('Location: /auth/formLogin');
            exit;
        }

        if ($_SESSION['user_role'] !== 'admin') {
            Flasher::setFlash('Akses ditolak', 'Anda bukan admin', 'danger');
            header('Location: /dashboard');
            exit;
        }

        $data['judul'] = 'Dashboard Admin';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/index');

    }
    
    public function Anggota(){
        $data['judul'] = 'Data Anggota';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/anggota');
    }

    public function Ruangan(){
        $data['judul'] = 'Data Ruangan';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/ruangan');
    }

    public function Akun(){
        $data['judul'] = 'Profile Admin';
        $this->view('Layout/Sidebar', $data);
        $this->view('Admin/akun');
    }

}