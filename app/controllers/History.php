<?php 

class History extends Controller{
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
        
        $data['judul'] = 'History';
        $this->view('Layout/Header', $data);
        $this->view('History/index', $data); 
        $this->view('Layout/Footer');
    }
}