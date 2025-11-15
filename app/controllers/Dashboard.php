<?php

class Dashboard extends controller
{

    public function __construct()
        {
            parent::__construct();
             if (!isset($_SESSION['user'])) {
            // Jika 'user_id' tidak ada di session (artinya belum login)
            Flasher::setFlash('Anda harus login', 'untuk mengakses halaman ini.', 'danger');
            header('Location: /auth/formLogin'); // Redirect ke halaman login
            exit; //Hentikan eksekusi script
            }

        }
    public function index(){

        $data['ruangan'] = $this->model('RuanganModel')->getRuanganForDashboard();
        $data['judul'] = 'Dashboard';
        $this->view('Layout/Header', $data);
        $this->view('dashboard/index', $data);
        $this->view('Layout/Footer');
    }
    public function History(){
        $data['judul'] = 'Riwayat Peminjaman';
        $this->view('Layout/Header', $data);
        $this->view('History/index', $data); 
        $this->view('Layout/Footer');
    }

    public function Booking($id = null){

        $id = param_number($id, "ID ruangan tidak valid");

        $data['detailRuangan'] = $this->model('RuanganModel')->getRuanganById($id);

    if (!$data['detailRuangan']) {
        http_response_code(404);
        die("Ruangan tidak ditemukan");
    }

        $data['judul'] = 'Booking Ruangan';
        $this->view('Layout/Header', $data);
        $this->view('Dashboard/Booking_Ruangan', $data); 
        $this->view('Layout/Footer');
    }


}
