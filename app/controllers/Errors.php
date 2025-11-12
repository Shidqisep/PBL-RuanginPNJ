
<?php

class Errors extends Controller {
    public function index(){
    http_response_code(404);
    $data['judul'] = '404 - Halaman Tidak Ditemukan';
    $data['message'] = 'Maaf, halaman yang Anda cari tidak ditemukan.';
    $this->view('Layout/Header', $data);
    $this->view('error/index', $data);
    $this->view('Layout/Footer', $data);
    }
}