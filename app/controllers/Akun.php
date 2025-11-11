<?php

class Akun extends Controller{

    public function __construct()
        {
            parent::__construct();
            if (!isset($_SESSION['user_id'])) {
            // Jika 'user_id' tidak ada di session (artinya belum login)
            Flasher::setFlash('Anda harus login', 'untuk mengakses halaman ini.', 'danger');
            header('Location: /auth/formLogin'); // Redirect ke halaman login
            exit; //Hentikan eksekusi script
            }
        }

    public function index(){
            // 1. Tentukan judul halaman
        $data['judul'] = 'Profil Akun';
        // 3. Panggil view (Urutan pemanggilan harus benar: Header, Body, Footer)
        $this->view('Layout/Header', $data);
        $this->view('Akun/index', $data); 
        $this->view('Layout/Footer');
    }

    public function forgetPassword(){
        $this->view('Auth/forgetPassword');
    }
}