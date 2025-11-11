<?php

// Pastikan Booking mewarisi dari Controller base class Anda
class History extends Controller 
{
    // Metode default saat mengakses URL /booking atau /booking/index
    public function index()
    {

        if (!isset($_SESSION['user_id'])) {
            // Jika 'user_id' tidak ada di session (artinya belum login)
            Flasher::setFlash('Anda harus login', 'untuk mengakses halaman ini.', 'danger');
            header('Location: /auth/formLogin'); // Redirect ke halaman login
            exit; //Hentikan eksekusi script
        }
        // 1. Tentukan judul halaman
        $data['judul'] = 'Riwayat Peminjaman';
        
        // 2. Ambil data yang diperlukan (jika ada)
        // Jika Anda perlu data user atau data ruangan tertentu, ambil di sini.
        // Contoh: $data['ruangan'] = $this->model('RuanganModel')->getRuangan($_GET['id']);

        // 3. Panggil view (Urutan pemanggilan harus benar: Header, Body, Footer)
        $this->view('Layout/Header', $data);
        
        // Asumsi: View Anda akan berada di 'app/view/booking/index.php'
        $this->view('History/index', $data); 
        
        $this->view('Layout/Footer');
    }
}