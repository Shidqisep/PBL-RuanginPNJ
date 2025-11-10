<?php

// Pastikan Booking mewarisi dari Controller base class Anda
class Booking extends Controller 
{
    // Metode default saat mengakses URL /booking atau /booking/index
    public function index()
    {
        // 1. Tentukan judul halaman
        $data['judul'] = 'Booking Ruangan';
        
        // 2. Ambil data yang diperlukan (jika ada)
        // Jika Anda perlu data user atau data ruangan tertentu, ambil di sini.
        // Contoh: $data['ruangan'] = $this->model('RuanganModel')->getRuangan($_GET['id']);

        // 3. Panggil view (Urutan pemanggilan harus benar: Header, Body, Footer)
        $this->view('Layout/Header', $data);
        
        // Asumsi: View Anda akan berada di 'app/view/booking/index.php'
        $this->view('Booking_Ruangan/index', $data); 
        
        $this->view('Layout/Footer');
    }
    
    // Anda bisa menambahkan metode lain, misalnya untuk memproses form booking:
    /*
    public function prosesBooking()
    {
        // Logika untuk memproses data POST dari form booking
    }
    */
}