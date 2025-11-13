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

}