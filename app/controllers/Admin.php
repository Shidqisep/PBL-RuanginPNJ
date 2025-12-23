<?php

class Admin extends Controller {

    public function __construct()
    {
        if (!isset($_SESSION['user'])){

            header('Location: /auth/formLogin');
            Flasher::setModalInfo('kamu belum login', 'silahkan login dulu', 'error');
            exit;
        }

        if ($_SESSION['role'] !== 'Admin' and $_SESSION['role'] !== 'Superadmin'){ 
            Flasher::setModalInfo('Akses ditolak', 'anda bukan admin', 'error');
            header('Location: /dashboard');
            exit;
        }
    }

    public function index(){
        $data['bookings'] = $this->model('BookingModel')->getAllActiveBookingJoinRoom();

        $bulanInput = isset($_GET['bulan']) && $_GET['bulan'] !== '' ? $_GET['bulan'] : []; // Default 1 tahun ini
        $tahunInput = isset($_GET['tahun']) && $_GET['tahun'] !== '' ? $_GET['tahun'] : date('Y'); // Default tahun ini

        if (!is_array($bulanInput)) {
            // Jika input dipisah koma (misal: ?bulan=01,02) atau single value
            $bulanFilter = explode(',', $bulanInput); 
        } else {
            $bulanFilter = $bulanInput;
        }

        // Paksa jadi array agar konsisten
        if (!is_array($tahunInput)) {
            $tahunFilter = explode(',', $tahunInput);
        } else {
            $tahunFilter = $tahunInput;
        }

        $jurusanFilter = [];
        if (isset($_GET['jurusan']) && $_GET['jurusan'] !== '') {
            if (is_array($_GET['jurusan'])) {
                $jurusanFilter = $_GET['jurusan'];
            } else {
                $jurusanFilter = explode(',', $_GET['jurusan']);
            }
        }

        $prodiFilter = [];
        if (isset($_GET['prodi']) && $_GET['prodi'] !== '') {
            if (is_array($_GET['prodi'])) {
                $prodiFilter = $_GET['prodi'];
            } else {
                $prodiFilter = explode(',', $_GET['prodi']);
            }
        }

        $dashboardModel = $this->model('DashboardModel');



        // A. Data Booking (Statistik Kartu Atas)
        // Kita kirim filter bulan & tahun
        $data['stats_booking'] = $dashboardModel->getBookingStats($bulanFilter, $tahunFilter);

        // B. Data Anggota (Statistik Kartu Tengah)
        // Kita kirim filter jurusan
        $data['stats_anggota'] = $dashboardModel->getUserStats($jurusanFilter, $prodiFilter);

        // C. Data Ruangan (Statistik Kartu Bawah)
        // Ruangan biasanya datanya global, tapi Populer bisa berdasarkan bulan/tahun aktif
        $data['stats_ruangan'] = $dashboardModel->getRoomStats();
        $data['judul'] = 'Dashboard Admin';
        $data['navbar'] = 'dashboard';
        $this->view('layout/sidebar', $data);
        $this->view('admin/index', $data);
    }

    // app/controllers/Admin.php

    public function cetakLaporan()
    {
        $data['judul'] = 'Laporan Peminjaman';

            //Ambil Filter (Sama seperti sebelumnya)
        if (isset($_GET['bulan']) && $_GET['bulan'] !== '') {

            if (is_array($_GET['bulan'])) {
                $bulanFilter = $_GET['bulan'];
            } else {
                // bulan=2,1 → ["2","1"]
                $bulanFilter = explode(',', $_GET['bulan']);
            }
        } else {
            $bulanFilter = []; // kosong = setahun penuh
        }

        if (isset($_GET['tahun']) && $_GET['tahun'] !== '') {
            if (is_array($_GET['tahun'])) {
                $tahunFilter = $_GET['tahun'];
            } else {
                // tahun=2023,2022 → ["2023","2022"]
                $tahunFilter = explode(',', $_GET['tahun']);
            }
        } else {
            $tahunFilter = [date('Y')]; // default tahun ini
        }

        $data['selected_bulan'] = $bulanFilter; 
        $data['selected_tahun'] = $tahunFilter;
        // 2. Ambil Data
        $data['laporan'] = $this->model('DashboardModel')->getAllBooking($bulanFilter, $tahunFilter);
        
        // 3. LOGIKA EXCEL vs PRINT
        $mode = isset($_GET['mode']) ? $_GET['mode'] : 'print';
        $data['mode'] = $mode; // Kirim mode ke view

        if ($mode == 'excel') {
            // Header khusus agar browser menganggap ini file Excel (.xls)
            $filename = "Laporan_Peminjaman_" . date('Ymd') . ".xls";
            
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            
            // Load view yang sama, tapi nanti di view kita matikan CSS/JS yang tidak perlu
            $this->view('Admin/cetak', $data);
        } else {
            // Mode Print Biasa
            $this->view('Admin/cetak', $data);
        }
    }

    public function cetakRuangan()
    {
        $data['judul'] = 'Laporan Peminjaman';
        // Panggil model yang tadi kita buat
        $data['laporan'] = $this->model('RuanganModel')->getLaporanRuangan();

        $mode = isset($_GET['mode']) ? $_GET['mode'] : 'print';

        $data['mode'] = $mode; // Kirim mode ke view

        if ($mode == 'excel') {
            // Header khusus agar browser menganggap ini file Excel (.xls)
            $filename = "Laporan_Ruangan_" . date('Ymd') . ".xls";
            
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");

            $this->view('Admin/cetakRuangan', $data);
        } else {
            // Mode Print Biasa
            $this->view('Admin/cetakRuangan', $data);
        }
    }

    public function cetakAnggota()
    {
        $data['judul'] = 'Laporan Anggota';
        //Ambil Filter (Sama seperti sebelumnya)
        if (isset($_GET['Jurusan']) && $_GET['Jurusan'] !== '') {

            if (is_array($_GET['Jurusan'])) {
                $jurusanFilter = $_GET['Jurusan'];
            } else {
                // bulan=2,1 → ["2","1"]
                $jurusanFilter = explode(',', $_GET['Jurusan']);
            }
        } else {
            $jurusanFilter = [];
        }
        //ambil role
        if (isset($_GET['Role']) && $_GET['Role'] !== '') {

            if (is_array($_GET['Role'])) {
                $roleFilter = $_GET['Role'];
            } else {
                $roleFilter = explode(',', $_GET['Role']);
            }
        } else {
            $roleFilter = []; // kosong
        }


        $data['laporan'] = $this->model('DashboardModel')->getAllUsers($jurusanFilter, $roleFilter);

        $mode = isset($_GET['mode']) ? $_GET['mode'] : 'print';
        $data['mode'] = $mode; // Kirim mode ke view

        if ($mode == 'excel') {
            // Header khusus agar browser menganggap ini file Excel (.xls)
            $filename = "Laporan_Peminjaman_" . date('Ymd') . ".xls";
            
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            
            // Load view yang sama, tapi nanti di view kita matikan CSS/JS yang tidak perlu
            $this->view('Admin/cetakAnggota', $data);
        } else {
            // Mode Print Biasa
            $this->view('Admin/cetakAnggota', $data);
        }
        
        // Load view khusus cetak (kita buat setelah ini)
        $this->view('Admin/cetakAnggota', $data);
    }
    
    public function Anggota(){

        $data['tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'approval';
        $data['current_page'] = 1;
        $data['total_page'] = 1;

        $data['limit'] = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $data['limit']) - $data['limit'] : 0;

        $statusFilter = ''; 
        if (isset($_GET['status'])) {
            if (is_array($_GET['status'])) {
                $statusFilter = $_GET['status']; 
            } else {
                $statusFilter = explode(',', $_GET['status']);
            }
        }

        $jurusanFilter = '';
        if (isset($_GET['jurusan'])) { 
            if (is_array($_GET['jurusan'])) {
                $jurusanFilter = $_GET['Jurusan']; 
            } else {
                $jurusanFilter = explode(',', $_GET['jurusan']);
            }
        }

        $jenisFilter = '';
        if (isset($_GET['jenis'])) {
            if (is_array($_GET['jenis'])) {
                $jenisFilter = $_GET['jenis']; 
            } else {
                $jenisFilter = explode(',', $_GET['jenis']);
            }
        }

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $userModel = $this->model('UserModel');

        if ($data['tab'] == 'approval') {
            $forcedStatus = 'pending'; 

            $data['users'] = $userModel->filterUsers($data['limit'], $start, $search, $forcedStatus, $jurusanFilter, $jenisFilter);

            $total_data = $userModel->countFilterUsers($search, $forcedStatus, $jurusanFilter, $jenisFilter);
            $data['link'] = 'selesaikan';
        } else {
            $data['users'] = $userModel->filterUsers($data['limit'], $start, $search, $statusFilter, $jurusanFilter, $jenisFilter);
            $total_data = $userModel->countFilterUsers($search, $statusFilter, $jurusanFilter, $jenisFilter);;
            $data['link'] = 'detailAnggota';
        }
        
        $data['total_page'] = ceil($total_data / $data['limit']);
        $data['current_page'] = $page;
        $data['judul'] = 'Data Anggota';
        $data['navbar'] = 'Anggota';
        $this->view('layout/sidebar', $data);
        $this->view('admin/anggota/index', $data);
    }

    public function detailAnggota($id = null){

        $id = param_number($id, "ID user tidak valid");

        if ($id  === false || $id  < 1) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /admin'); // Redirect ke halaman admin
            exit;
        }
        $data['user'] = $this->model('UserModel')->getUserAndRoleById($id);
        $date1 = new DateTime($data['user']['created_at'] ?? '');
        $date2 = new DateTime($data['user']['expired_at'] ?? '');
        $data['masaAktif'] = $date1->diff($date2)->y; 
        $data['judul'] = 'Detail Anggota';
        $data['navbar'] = 'Anggota';
        $this->view('layout/sidebar', $data);
        $this->view('admin/anggota/detail', $data);
    }

    public function Selesaikan($id_user = null){

        $id = param_number($id_user, "ID ruangan tidak valid");

        if ($id  === false || $id  < 1) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /admin'); // Redirect ke halaman login
            exit;
        }

        $data['user'] = $this->model('UserModel')->getPendingUserJoinRoleById($id_user);

        if (!$data['user']) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /admin'); // Redirect ke halaman login
            exit;
        }

        $data['createdDate'] = tanggal_indonesia($data['user']['created_at']);
        $data['judul'] = 'Selesaikan Peminjaman';
        $data['navbar'] = 'Anggota';

        $this->view('layout/sidebar', $data);
        switch ($data['user']['role_name']) {
            case 'Mahasiswa':
                $this->view('admin/anggota/selesaikan', $data);
                break;
            case 'Dosen':
                $this->view('admin/anggota/selesaikanDosen', $data);
                break;
            default:
                $this->view('admin/anggota/selesaikanDosen', $data);
                break;
        }
        $this->view('layout/sidebar', $data);
    }

    public function selesaikanDosen($id_user = NULL){

        $id = param_number($id_user, "ID ruangan tidak valid");

        if ($id  === false || $id  < 1) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /admin'); // Redirect ke halaman login
            exit;
        }

        $data['user'] = $this->model('userModel')->getPendingUserJoinRoleById($id_user);
        $data['createdDate'] = tanggal_indonesia($data['user']['created_at']);
        $data['judul'] = 'Selesaikan Dosen/Tendik';
        $data['navbar'] = 'Anggota';
        $this->view('layout/sidebar', $data);
        $this->view('admin/anggota/selesaikanDosen');
    }

    public function tambahAnggota(){
        $data['judul'] = 'Tambah Anggota Baru';
        $data['navbar'] = 'Anggota';
        $data['dataJurusan'] = getJurusan();
        $data['dataProdi'] = getProdi();
        $this->view('layout/sidebar', $data);
        $this->view('admin/anggota/tambahAnggota', $data);
    }
    
    public function peminjaman(){

        $data['tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'hariIni';
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $data['limit'] = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $data['limit']) - $data['limit'] : 0;
        $statusFilter = ''; 
        if (isset($_GET['status'])) {
            if (is_array($_GET['status'])) {
                $statusFilter = $_GET['status']; 
            } else {
                $statusFilter = explode(',', $_GET['status']);
            }
        }

        if ($data['tab'] == 'reschedule') {
            // --- LOGIKA RESCHEDULE ---
            $data['id_column'] = 'id_reschedule';
            $data['link'] = 'detailReschedule';

            // Panggil fungsi filter khusus Reschedule
            $data['Peminjamans'] = $this->model('RescheduleModel')->filterReschedules(
                $data['limit'], $start, $search, $statusFilter
            );
            $total_data = $this->model('RescheduleModel')->countFilterReschedules($search, $statusFilter);

        } else {
            // --- LOGIKA BOOKING (hariIni, berlangsung, riwayat) ---
            $data['id_column'] = 'id_booking';
            
            // Tentukan aturan (Constraint) berdasarkan Tab
            $dateMode = '';     // 'today', 'upcoming', 'all'
            $forcedStatus = []; // Jika tab memaksa status tertentu

            switch ($data['tab']) {
                case 'hariIni':
                    $dateMode = 'today'; 
                    // Status biasanya yang aktif saja, atau semua status di hari ini? Sesuaikan kebutuhan.
                    $data['link'] = 'hariIni';
                    break;

                case 'berlangsung':
                    // Biasanya status 'approved' atau 'pending' dan tanggal >= hari ini
                    $dateMode = 'upcoming';
                    // Jika user tidak milih filter status, kita paksa status 'active'
                    if (empty($statusFilter)) {
                        $forcedStatus = ['approved', 'pending', 'ongoing', 'ongoing']; 
                    }
                    $data['link'] = 'detailBerlangsung';
                    break;

                case 'riwayat':
                    // Status selesai/batal/rejected
                    $dateMode = 'all'; // atau 'all'
                    if (empty($statusFilter)) {
                        $forcedStatus = ['done', 'cancelled', 'rejected', 'pending', 'active', 'ongoing'];
                    }
                    $data['link'] = 'detailRiwayat';
                    break;
                    
                default:
                    // Fallback ke hari ini
                    $dateMode = 'today';
                    $data['link'] = 'hariIni';
                    break;
            }

            // Jika ada forcedStatus (dari logika tab), gunakan itu. 
            // Jika tidak, gunakan $statusFilter (dari checkbox user).
            $finalStatus = !empty($forcedStatus) ? $forcedStatus : $statusFilter;

            // Panggil SATU fungsi model untuk semua tab Booking
            $data['Peminjamans'] = $this->model('BookingModel')->filterBookings($data['limit'], $start, $search, $finalStatus, $dateMode);

            $total_data = $this->model('BookingModel')->countFilterBookings($search, $finalStatus, $dateMode);
        }
        $data['total_page'] = ceil($total_data / $data['limit']);
        $data['current_page'] = $page;

        $data['judul'] = 'Peminjaman';
        $data['navbar'] = 'Peminjaman';
        $this->view('layout/sidebar', $data);
        $this->view('admin/peminjaman/index', $data);
    }

    public function hariIni($id_booking = NULL){
         $id_res = param_number($id_booking);

        if ($id_res  === false || $id_booking  < 1) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /admin'); // Redirect ke halaman login
            exit;
        }
        
        $data['detailBooking'] = $this->model('BookingModel')->getBookingDetail($id_booking);
        // var_dump($data['detailBooking']);
        $data['members'] = $this->model('BookingModel')->getBookingMembers($id_booking);
        $data['judul'] = 'Detail Peminjaman Hari Ini';
        $data['navbar'] = 'Peminjaman';
        $this->view('layout/sidebar', $data);
        $this->view('admin/peminjaman/detailHariIni', $data);
    }

    public function detailReschedule($id_res = NULL){

        $id_res = param_number($id_res);

        if ($id_res  === false || $id_res  < 1) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /admin'); // Redirect ke halaman login
            exit;
        }

        $data['reschedule'] = $this->model('RescheduleModel')->getRescheduleDetail($id_res);
        $data['members'] = $this->model('RescheduleModel')->getRescheduleMembers($id_res);
        $data['judul'] = 'Detail Reschedule';
        $data['navbar'] = 'Peminjaman';
        $this->view('layout/sidebar', $data);
        $this->view('admin/peminjaman/detailReschedule', $data);
    }

    public function detailBerlangsung($id_booking = NULL){

        $id_res = param_number($id_booking);

        if ($id_res  === false || $id_booking  < 1) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /admin'); // Redirect ke halaman login
            exit;
        }


        $data['detailBooking'] = $this->model('BookingModel')->getBookingDetail($id_booking);
        // var_dump($data['detailBooking']);
        $data['members'] = $this->model('BookingModel')->getBookingMembers($id_booking);
        $data['judul'] = 'Detail Peminjaman yang Berlangsung';
        $data['navbar'] = 'Peminjaman';
        $this->view('layout/sidebar', $data);
        $this->view('admin/peminjaman/detailBerlangsung', $data);
    }

    public function detailRiwayat($id_booking = NULL){
        $id_booking = param_number($id_booking);

        if ($id_booking  === false || $id_booking  < 1) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /admin'); // Redirect ke halaman login
            exit;
        }
         $data['detailBooking'] = $this->model('BookingModel')->getBookingDetail($id_booking);
        // var_dump($data['detailBooking']);
        $data['members'] = $this->model('BookingModel')->getBookingMembers($id_booking);
        $data['judul'] = 'Detail Riwayat Peminjaman';
        $data['navbar'] = 'Peminjaman';
        $this->view('layout/sidebar', $data);
        $this->view('admin/peminjaman/detailRiwayat', $data);
    }

    public function buatPeminjaman(){

        $data['limit'] = 5; // Jumlah data per halaman
        
        // 2. Ambil Search Key
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // 3. Logika Halaman (Pagination)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Hitung START (Offset) sesuai rumus kamu
        $start = ($page > 1) ? ($page * $data['limit']) - $data['limit'] : 0;

        $statusFilter = ['active', 'non-active'];

        // Panggil Model (DIPISAH)
        // Ambil data baris ruangan
        $data['rooms'] = $this->model('RuanganModel')->getRuanganForAdmin($search, $statusFilter ,  $data['limit'], $start);

        // Hitung total data untuk pagination
        $total_data = $this->model('RuanganModel')->countRuanganForAdmin($search, $statusFilter);

        // 5. Hitung Total Halaman
        $data['total_page'] = ceil($total_data / $data['limit']);
        $data['current_page'] = $page;
        $data['rapat'] = $this->model('RuanganModel')->getRuangRapat();
        $data['judul'] = 'Buat Pinjaman Baru';
        $data['navbar'] = 'Peminjaman';
        $this->view('layout/sidebar', $data);
        $this->view('admin/Peminjaman/buatBooking', $data);
    }

    public function bookingRuangan($id_room = NULL){

        $id = param_number($id_room, "ID ruangan tidak valid");

        if ($id_room === false || $id_room < 1) {
                Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
                header('Location: /admin/buatBooking'); // Redirect ke halaman login
                exit;
            }

        $data['detailRuangan'] = $this->model('RuanganModel')->getRuanganWithRating($id);

        if (!$data['detailRuangan']) {
            http_response_code(404);
            die("Ruangan tidak ditemukan");
        }

        $data['judul'] = 'Buat Pinjaman Baru';
        $data['navbar'] = 'Peminjaman';
        $this->view('layout/sidebar', $data);
        $this->view('admin/Peminjaman/bookingRuangan', $data);
    }

    public function bookingRuangRapat(){
        $data['rapat'] = $this->model('RuanganModel')->getRuangRapat();
        $data['judul'] = 'Buat Pinjaman Baru';
        $data['navbar'] = 'Peminjaman';
        $this->view('layout/sidebar', $data);
        $this->view('admin/Peminjaman/bookingRuangRapat', $data);
    }

    public function Ruangan(){
        $data['limit'] = 6; // Jumlah data per halaman  
        
        // Ambil Search Key
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Logika Halaman (Pagination)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Hitung offset
        $start = ($page > 1) ? ($page * $data['limit']) - $data['limit'] : 0;

        //ini buat filter status
        $statusFilter = ''; 
        if (isset($_GET['status']) && $_GET['status'] !== '') {
            if (is_array($_GET['status'])) {
                $statusFilter = $_GET['status']; 
            } else {
                $statusFilter = explode(',', $_GET['status']);
            }
        }
        // 4. Panggil Model (DIPISAH)
        // Ambil data baris ruangan
        $data['rooms'] = $this->model('RuanganModel')->getRuanganForAdmin($search, $statusFilter, $data['limit'], $start);

        // Hitung total data untuk pagination
        $total_data = $this->model('RuanganModel')->countRuanganForAdmin($search);


        $data['total_page'] = ceil($total_data / $data['limit']);
        $data['current_page'] = $page;
        $data['judul'] = 'Data Ruangan';
        $data['navbar'] = 'Ruangan';
        $this->view('layout/sidebar', $data);
        $this->view('admin/ruangan/index', $data);
    }

    public function tambahDataRuangan(){
        $data['judul'] = 'Tambah Data Ruangan';
        $data['navbar'] = 'Ruangan';
        $this->view('layout/sidebar', $data);
        $this->view('admin/ruangan/tambahRuangan');
    }

    public function EditDataRuangan($id_room = NULL){
         $id = param_number($id_room, "ID ruangan tidak valid");

        if ($id_room === false || $id_room < 1) {
                Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
                header('Location: /admin/ruangan'); // Redirect ke halaman login
                exit;
            }
        $data['room'] = $this->model('RuanganModel')->getRuanganWithRating($id_room);
        $data['judul'] = 'Edit Data Ruangan';
        $data['navbar'] = 'Ruangan';
        $this->view('layout/sidebar', $data);
        $this->view('admin/ruangan/editDataRuangan', $data);
    }

    public function EditTataTertib(){
        $data['tatib'] = $this->model('AnnouncementModel')->getAnnouncement(1);
        $data['judul'] = 'Edit Tata Tertib';
        $data['navbar'] = 'Ruangan';
        $this->view('layout/sidebar', $data);
        $this->view('admin/ruangan/editTataTertib', $data);
    }

    public function dataRuangan(){
        // $data['ruangan'] = $this->model('RuanganModel')->getAllRooms 
        $data['judul'] = 'Detail Ruangan';
        $data['navbar'] = 'Ruangan';
        $this->view('layout/sidebar', $data);
        $this->view('admin/ruangan/dataRuangan');
    }

    public function Feedback(){
        $data['limit'] = 2; // Limit data per halaman
        
        // 1. Logika Halaman (Pagination)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $data['limit']) - $data['limit'] : 0;

        // 2. Logika Filter
        // Filter Ruangan
        $ruanganFilter = [];
        if (isset($_GET['ruangan']) && $_GET['ruangan'] !== '') {
            if (is_array($_GET['ruangan'])) {
                $ruanganFilter = $_GET['ruangan'];
            } else {
                $ruanganFilter = explode(',', $_GET['ruangan']);
            }
        }

        // Filter Bulan
        $bulanFilter = [];
        if (isset($_GET['bulan']) && $_GET['bulan'] !== '') {
            if (is_array($_GET['bulan'])) {
                $bulanFilter = $_GET['bulan'];
            } else {
                $bulanFilter = explode(',', $_GET['bulan']);
            }
        }

        // Filter Tahun
        $tahunFilter = [];
        if (isset($_GET['tahun']) && $_GET['tahun'] !== '') {
            if (is_array($_GET['tahun'])) {
                $tahunFilter = $_GET['tahun'];
            } else {
                $tahunFilter = explode(',', $_GET['tahun']);
            }
        }

        // 3. Panggil Model
        // Kita mengirimkan variabel filter ke Model
        $feedbackModel = $this->model('FeedbackModel');

        // Ambil data feedback dengan filter
        $data['feedbacks'] = $feedbackModel->getFeedbackFiltered(
            $data['limit'], 
            $start,
            $ruanganFilter, 
            $bulanFilter, 
            $tahunFilter
        );

        // Hitung total data (harus memuat filter juga agar pagination akurat)
        $total_data = $feedbackModel->countFeedbackFiltered(
            $ruanganFilter, 
            $bulanFilter, 
            $tahunFilter
        );

        // 4. Kelengkapan Data View
        $data['total_page'] = ceil($total_data / $data['limit']);
        $data['current_page'] = $page;
        
        // Kirim opsi filter kembali ke view (agar checkbox tetap tercentang setelah reload)
        $data['list_ruangan'] = $this->model('RuanganModel')->getAllRoomNames();

        $data['judul'] = 'Feedback Pengguna';
        $data['navbar'] = 'Feedback';
        
        $this->view('layout/sidebar', $data);
        $this->view('admin/feedback/index', $data);
    }

    public function detailAdmin(){
        $data['judul'] = 'Detail Data Admin';
        $data['navbar'] = 'superAdmin';
        $this->view('layout/sidebar', $data);
        $this->view('admin/superAdmin/detailAdmin', $data);
    }

    public function tambahAdmin(){
        $data['judul'] = 'Tambah Data Admin';
        $data['navbar'] = 'superAdmin';
        $this->view('layout/sidebar', $data);
        $this->view('admin/superAdmin/tambahAdmin', $data);
    }

    public function Akun(){
        $data['judul'] = 'Profile Admin';
        $data['navbar'] = 'Akun';
        $this->view('layout/sidebar', $data);
        $this->view('admin/akun/index');
    }

    public function gantiPassword(){
        $data['judul'] = 'Ganti Password';
        $data['navbar'] = 'Akun';
        $this->view('layout/sidebar', $data);
        $this->view('admin/akun/gantiPassword');
    }

    public function hapusAkun(){
        $data['judul'] = 'Hapus Akun';
        $data['navbar'] = 'Akun';
        $this->view('layout/sidebar', $data);
        $this->view('admin/akun/hapusAkun');
    }

    //ini approve user
    public function handleApprove(){

        try{

        if (empty($_POST['id_user']) || empty($_POST['email'])|| empty($_POST['username']) ) {
            throw new Exception('Error, data tidak lengkap ');
        }

        if ($this->model('UserModel')->getStatusUserById($_POST['id_user'])['status'] === 'active') {
            throw new Exception('Anggota sudah aktif');
        }

        $result = $this->model('UserModel')->activateUser($_POST['id_user']);
        if ($result === 0 ) {
            throw new Exception('internal sql error');
        }
        sendEmail($_POST['email'] ?? 'email user', $_POST['username' ?? 'user'], "SELAMAT AKUN ANDA TELAH AKTIF", "anda sekarang bisa login ke ruanginPNJ" );
        Flasher::setModalInfo('Berhasil Approve Anggota', 'Akun anggota sudah bisa digunakan');
        header('location: /admin/anggota');
        exit();

        }catch(Throwable $e){
            Flasher::setModalInfo('Gagal Aktivasi User', $e->getMessage(), 'error');
            header('location: /admin/anggota');
            exit();
        }
    }

    //ini decline user
    public function handleDecline(){
        
        try{

        if (empty($_POST['id_user']) || empty($_POST['email'])|| empty($_POST['username'])) {
            throw new Exception('Error id_user tidak ada');
        }

        $result = $this->model('UserModel')->rejectUser($_POST['id_user']);
        if ($result === 0 ) {
            throw new Exception('internal sql error');
        }

        sendEmail($_POST['email'], $_POST['username'], "Mohon Maaf akun anda ditolak", "alasannya: " . ($_POST['alasan'] ?? 'tidak ada alasan spesifik') );
        Flasher::setModalInfo('Berhasil Tolak Anggota', 'Akun anggota sudah ditolak');
        header('location: /admin/anggota');
        exit();

        }catch(Throwable $e){
            Flasher::setModalInfo('Gagal Decline user', $e->getMessage(), 'error');
            header('location: /admin/anggota');
            exit();
        }
    }

    public function handleSuspend(){
        try{

        if (empty($_POST['id_user']) || empty($_POST['email'])|| empty($_POST['username'])) {
            throw new Exception('Error id_user tidak ada');
        }

        $result = $this->model('UserModel')->addSuspendCount($_POST['id_user']);
        if ($result === 0 ) {
            throw new Exception('internal sql error');
        }

        sendEmail($_POST['email'], $_POST['username'], "suspend count anda telah bertambah 1", "Merasa tidak adil? segera hubungi admin untuk informasi lebih lanjut");
        Flasher::setModalInfo('Berhasil Menambahkan Suspend Anggota', 'suspend count anggota telah ditambahkan');
        header('location: /admin/anggota?tab=anggota');
        exit();

        }catch(Throwable $e){
            Flasher::setModalInfo('Gagal Suspend user', $e->getMessage(), 'error');
            header('location: /admin/anggota?tab=semua');
            exit();
        }
    }

    public function handleNonActivate(){
        try {
            if (empty($_POST['id_user']) || empty($_POST['email'])|| empty($_POST['username'])) {
                throw new Exception('Error, data tidak lengkap');
            }

            $result = $this->model('UserModel')->nonActivateUser($_POST['id_user']);
            if ($result === 0 ) {
                throw new Exception('internal sql error');
            }
            sendEmail($_POST['email'] ?? 'email user', $_POST['username' ?? 'user'], "Akun anda di nonaktifkan admin! kembali", "Silahkan Hubungi Admin" );
            Flasher::setModalInfo('Berhasil nonaktifkan akun anggota', 'Akun anggota telah suspended');
            header('location: /admin/anggota');
            exit();

        } catch (\Throwable $e) {
            Flasher::setModalInfo('Gagal Aktivasi user', $e->getMessage(), 'error');
            header('location: /admin/anggota?tab=anggota');
            exit();
        }

    }

    public function handleActivate(){
        try {
            if (empty($_POST['id_user']) || empty($_POST['email'])|| empty($_POST['username'])) {
                throw new Exception('Error, data tidak lengkap');
            }

        
        if ($this->model('UserModel')->getStatusUserById($_POST['id_user'])['status'] === 'active') {
            throw new Exception('Anggota sudah aktif');
        }

        $result = $this->model('UserModel')->activateUser($_POST['id_user']);
        if ($result === 0 ) {
            throw new Exception('internal sql error');
        }
        sendEmail($_POST['email'] ?? 'email_user', $_POST['username' ?? 'user'], "Akun anda telah aktif kembali", "anda sekarang bisa login ke ruanginPNJ" );
        Flasher::setModalInfo('Berhasil Aktifkan Anggota', 'Akun anggota sudah bisa aktif kembali');
        header('location: /admin/anggota');
        exit();

        } catch (\Throwable $e) {
            Flasher::setModalInfo('Gagal Aktivasi user', $e->getMessage(), 'error');
            header('location: /admin/anggota?tab=anggota');
            exit();
        }
    }

    public function handleRegisterByAdmin(){
        try {

            if (!$_POST['username'] || !$_POST['password'] || !$_POST['email'] || !$_POST['nomor_induk']) {
                throw new Exception('Data tidak lengkap');
            }

            $role = $_POST['jenis_anggota'] ?? NULL;

            switch ($role) {
                case "mahasiswa":
                    $id_role = 3;
                    break;
                case "dosen":
                    $id_role = 4;
                    break;
                case "tendik":
                    $id_role = 5;
                    break;
                default:
                    throw new Exception("Error Internal", 1);
                break;
            }

            if (!validateNIM($_POST['nomor_induk'])) {
                throw new Exception('NIM hanya boleh berisi angka');
            }

            if (!validatePassword($_POST['password'])) {
                throw new Exception('Password minimal 6 huruf dan 1 angka');
            }

            if ($id_role === 3) {
                if (!validateEmail($_POST['email'])) {
                    throw new Exception('Email tidak valid');
                }
                $jurusan_unit = $_POST['jurusan_unit'];
                $expiredDate = countExpiredAt($_POST['email'], $_POST['prodi']);
            } else {
                $jurusan_unit = $_POST['jurusan_text'];
            }

            

            $data = [
                'id_role' => $id_role,
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                'nomor_induk' => $_POST['nomor_induk'],
                'email' => $_POST['email'],
                'jurusan_unit' => $jurusan_unit,
                'prodi' => $_POST['prodi'] ?? NULL,
                'status' => 'active',
                'kubaca_photo' => NULL,
                'profile_photo' => 'DefaultProfilePicture.jpg',
                'suspend_count' => 0,
                'email_verified' => true,
                'expired_at' => $expiredDate ?? NULL,
                'now' => date('Y-m-d H:i:s')
            ];

            if ($this->model('UserModel')->findUserByEmailorNomor_Induk($data['email'], $data['nomor_induk'])) {
                throw new Exception('Email atau NIM sudah terdaftar!');
            }

            $result = $this->model('UserModel')->createUser($data);
            if ($result <= 0) {
                throw new Exception('Something Went Wrong');
            }

            Flasher::setModalInfo('Berhasil', 'Membuat Anggota Baru', 'success');
            header('location: /admin/anggota');
            exit();
        } catch (\Throwable $e) {
            Flasher::setModalInfo('Gagal Daftarkan Anggota', $e->getMessage(), 'error');
            header('location: /admin/anggota');
            exit();
        }
    }

    public function handlePasswordChange(){

        //ga boleh kosong
        if (empty($_POST['passwordBaru']) || empty($_POST['password']) || empty($_POST['passwordBaruConfirm'])) {
            Flasher::setModalInfo('Password tidak boleh kosong', 'Silahkan isi password', 'error');
            header('location: /admin/akun');
            exit();
        }

        // kalo beda sama yang confirm maka salah
        if ($_POST['passwordBaru'] !== $_POST['passwordBaruConfirm']) {
            Flasher::setModalInfo('Password tidak sama', 'Silahkan isi password dengan benar', 'error');
            header('location: /admin/akun');
            exit();
        }

        $oldPassword = $this->model('UserModel')->getPasswordByEmail($_SESSION['user']['email']);
        // var_dump($_SESSION['user']['email']);
        // var_dump($oldPassword);
        // var_dump($_POST['password']);
        // var_dump(password_verify($_POST['passwordBaru'], $oldPassword['password']));
        // die();
        if (!$oldPassword) {
            Flasher::setModalInfo('Akun tidak ditemukan', 'Internal server error', 'error');
            header('location: /admin/akun');
            exit();
        }

        if (!password_verify($_POST['password'], $oldPassword['password'])) {
            Flasher::setModalInfo('Password lama salah', 'Silahkan masukan password yang benar', 'error');
            header('location: /admin/akun');
            exit();
        }
        
        $data = [
            'password' => password_hash($_POST['passwordBaru'], PASSWORD_DEFAULT),
            'email' => $_SESSION['user']['email']
        ];
        $result = $this->model('UserModel')->updatePassword($data);

        if ($result === 0){
            Flasher::setModalInfo('Password sama dengan yang dulu', 'Gagal update atau Password sama', 'error');
            header('location: /admin/akun');
            exit();
        }

            Flasher::setModalInfo('Berhasil', 'Password berhasil diubah', 'success');
            unset($_SESSION['user']); // Hapus session user
            unset($_SESSION['role']);
            // session_destroy(); // Hancurkan session
            header('location: /auth/'); // Logout paksa setelah ganti password
        exit();
    }

    public function approveReschedule(){

       if (!isset($_POST['id_reschedule']) || !isset($_POST['email']) || !isset($_POST['username'])) {
        Flasher::setModalInfo('Data tidak lengkap', 'ID, Email, atau Username tidak ditemukan.', 'error');
        header('location: ' . BASEURL . '/admin/Peminjaman?tab=reschedule');
        exit();
    }

        $id_reschedule = $_POST['id_reschedule'];
        $email = $_POST['email'];
        $username = $_POST['username'];

        // Inisialisasi Model
        $modelReschedule = $this->model('RescheduleModel');
        $modelBooking = $this->model('BookingModel');

        // Mulai Transaksi Database
        $modelBooking->beginTransaction();

        try {
            // VALIDASI DATA & STATUS
            $resData = $modelReschedule->getRescheduleJoinBooking($id_reschedule);

            if (!$resData) {
                throw new Exception("Data reschedule tidak ditemukan.");
            }
            
            // Cek apakah statusnya pending? Kalau tidak, tolak.
            if ($resData['status_reschedule'] !== 'pending') {
                throw new Exception("Request ini sudah tidak valid (bukan pending).");
            }

            // Cek Bentrok Jadwal Baru
            $conflict = $modelBooking->roomCheck(
                $resData['id_room'],
                $resData['new_end_time'],
                $resData['new_start_time']
                // $resData['id_booking'] // Opsional: exclude booking sendiri jika logic query membutuhkannya
            );

            if ($conflict['total'] > 0) {
                throw new Exception("Gagal! Ruangan sudah terisi oleh jadwal lain pada jam tersebut.");
            }

            // Hitung total orang baru (Member + 1 Ketua)
            $totalMembers = $modelReschedule->countRescheduleMembers($id_reschedule);
            $totalPerson = $totalMembers + 1;

            // Update Jadwal & Total Orang di Tabel Booking
            $modelBooking->updateScheduleAndTotalPerson(
                $resData['id_booking'],
                $resData['new_start_time'],
                $resData['new_end_time'],
                $totalPerson
            );

            // SINKRONISASI ANGGOTA
            // 1. Hapus anggota lama di booking
            $modelBooking->clearBookingMembers($resData['id_booking']);
            
            // 2. Masukkan anggota baru dari tabel reschedule ke tabel booking_members
            $modelBooking->importMembersFromReschedule($resData['id_booking'], $id_reschedule);

            // FINALISASI (Update Status Reschedule jadi Approved)
            $modelReschedule->updateStatus($id_reschedule, 'approved');
            
            // Format Waktu untuk Email (Opsional, biar cantik)
            $tglBaru = date('d F Y', strtotime($resData['new_start_time']));
            $jamMulai = date('H:i', strtotime($resData['new_start_time']));
            $jamSelesai = date('H:i', strtotime($resData['new_end_time']));

            $emailSubject = "Pengajuan Reschedule Anda Disetujui!";
            $emailBody = "Halo $username,\n\n" .
                        "Kabar baik! Pengajuan reschedule Anda telah DISETUJUI oleh admin.\n" .
                        "Jadwal peminjaman Anda telah diperbarui menjadi:\n\n" .
                        "Tanggal: $tglBaru\n" .
                        "Jam: $jamMulai - $jamSelesai WIB\n\n" .
                        "Silakan cek detail peminjaman Anda di aplikasi.";

            sendEmail($email, $username, $emailSubject, $emailBody);
            //kalo berhasiil kirim email ya commit
            $modelBooking->commit();

            Flasher::setModalInfo('Berhasil', 'Reschedule disetujui dan jadwal telah diperbarui.', 'success');
            header('location: ' . BASEURL . '/admin/Peminjaman?tab=reschedule');
            exit;

        } catch (Exception $e) {
            // Jika ada error di tahap manapun, BATALKAN SEMUA
            $modelBooking->rollback();
            
            Flasher::setModalInfo('Gagal', $e->getMessage(), 'error');
            // Redirect kembali ke detail jika gagal, atau ke list
            header('Location: ' . BASEURL . '/admin/Peminjaman?tab=reschedule');
            exit;
        }
    }

    public function declineReschedule(){
        // 1. Cek parameter ID & Alasan
        if (!isset($_POST['id_reschedule']) || !isset($_POST['alasan'])) {
            Flasher::setModalInfo('Data tidak lengkap', 'ID atau Alasan harus diisi', 'error');
            header('location: ' . BASEURL . '/admin/Peminjaman?tab=reschedule');
            exit();
        }

        $id_reschedule = $_POST['id_reschedule'];
        $alasan = $_POST['alasan']; // Tangkap alasannya
        $email = $_POST['email'];
        $username = $_POST['username'];
        // Validasi sederhana: Alasan tidak boleh kosong stringnya
        if (trim($alasan) == '') {
            Flasher::setModalInfo('Alasan Kosong', 'Harap isi alasan penolakan', 'warning');
            header('location: ' . BASEURL . '/admin/Peminjaman?tab=reschedule');
            exit();
        }

        $rescheduleModel = $this->model('RescheduleModel');

        // 2. Cek ID di DB (sama kayak sebelumnya)
        $existingData = $rescheduleModel->getRescheduleById($id_reschedule);
        if (!$existingData) {
            Flasher::setModalInfo('Gagal', 'Data tidak ditemukan.', 'error');
            header('Location: ' . BASEURL . '/admin/Peminjaman?tab=reschedule');
            exit;
        }

        // 3. Update Status DAN Alasan
        // Parameter ke-3 adalah alasannya
        $result = $rescheduleModel->updateStatus($id_reschedule, 'declined', $alasan);
        
        if ($result > 0) {
            Flasher::setModalInfo('Berhasil', 'Reschedule ditolak dengan alasan.', 'success');
            sendEmail($email, $username, "Pengajuan Reschedule Anda Ditolak", "Pengajuan reschedule Anda telah ditolak oleh admin dengan alasan berikut:\n\n" . $alasan );
        } else {
            Flasher::setModalInfo('Gagal', 'Tidak ada perubahan data.', 'error');
        }
        header('Location: ' . BASEURL . '/admin/Peminjaman?tab=reschedule');
        exit;
    }

    // ini buat booking yang dari admin
    public function handleBooking(){
        Flasher::modalInfo();

        $id_room = $_POST['id_room'] ?? NULL;
        $bookingDate = $_POST['tanggalPinjam']?? NULL;
        $startTime = $_POST['jamMulai']?? NULL;
        $endTime = $_POST['jamSelesai']?? NULL;

        if (!$id_room || !$bookingDate || !$startTime || !$endTime) {
            Flasher::setModalInfo('Gagal!', 'Semua field wajib diisi', 'error');
            header("Location: /admin/buatPeminjaman");
        exit;
        }


        if (!isset($_POST['nim']) || !is_array($_POST['nim'])) {
            // Handle jika tidak ada input NIM sama sekali
            Flasher::setModalInfo('Gagal!', 'Data anggota tidak valid', 'error');
            header("Location: /admin/buatPeminjaman");
            exit;
        }

        $nomorIndukKetua = $_POST['nim'][0];
        $list_nim_anggota = array_slice($_POST['nim'], 1); 

        
        $start_datetime = "$bookingDate $startTime";
        $end_datetime   = "$bookingDate $endTime";

        $ts = strtotime($bookingDate);
        $range_start = date('Y-m-d 00:00:00', strtotime('monday this week', $ts));
        $range_end   = date('Y-m-d 23:59:59', strtotime('sunday this week', $ts));

        $bookingCode = generateBookingCode(8);

        $bookingModel = $this->model('BookingModel');
        $userModel = $this->model('UserModel');
        $rescheduleModel = $this->model('RescheduleModel');


        try {
                $bookingModel->beginTransaction();
                $userKetua = $userModel->getUserByNomor_Induk($nomorIndukKetua);
            if (!$userKetua) {
                throw new Exception('Nomor Induk ketua tidak ditemukan');
            }

            if (!$bookingModel->checkUserQuota($userKetua['id_user'], $range_start, $range_end)) {
                throw new Exception('Ketua sudah ada booking');
            }

            $id_ketua = $userKetua['id_user'];

                $cekRoom = $bookingModel->roomCheck($id_room, $end_datetime, $start_datetime);
            if ($cekRoom['total'] > 0) {
                throw new Exception("Ruangan sudah di booking pada jam itu!");
            }

            $validatedUsers = [];

            foreach ($list_nim_anggota as $nim) {
                $nim = trim($nim);
                if (empty($nim)) continue; // Skip jika kosong

            // Cek User
                $userAnggota = $userModel->getUserByNomor_Induk($nim);
                if(!$userAnggota) throw new Exception("NIM Anggota ($nim) tidak ditemukan.");

            // Cek apakah Anggota ini malah jadi Ketua? (Opsional, validasi biar ga input diri sendiri)
                if($userAnggota['id_user'] == $id_ketua) {
                     throw new Exception("Ketua tidak perlu dimasukkan lagi sebagai anggota.");
                }

            // Cek Kuota Anggota
                if (!$bookingModel->checkUserQuota($userAnggota['id_user'], $range_start, $range_end)) {
                    throw new Exception("Anggota (" . $userAnggota['username'] . ") sudah ada jadwal minggu ini.");
                }

                if ($rescheduleModel->checkUserHasReschedule($userAnggota['id_user'])) {
                    throw new Exception("Anggota (" . $userAnggota['username'] . ") sudah ada di anggota reschedule orang lain.");
                }

            // Simpan ID anggota yang valid
            $validatedUsers[] = $userAnggota['id_user'];
            }

            $total_person = 1 + count($validatedUsers);

            $dataBooking = [
                        'id_room' => $id_room,
                        'id_user' => $id_ketua,
                        'booker_name' => $userKetua['username'],
                        'total_person' => $total_person,
                        'booking_code' => $bookingCode,
                        'start_time' => $start_datetime,
                        'end_time' => $end_datetime
                    ];

            $newBookingId = $bookingModel->createBooking($dataBooking);

            foreach($validatedUsers as $id_member){
                $bookingModel->insertBookingMember((int)$newBookingId, $id_member);
            }
            //auto cancel misalnya ada reschedule yang mengarah ke jam dan tanggal yang sama
            $rescheduleModel->autoCancelRescheduleConflict($id_room, $start_datetime, $end_datetime);
            //decline reschedulenya kalo si ketua ini masuk ke anggota reschedulenya orang lain
            $rescheduleModel->declinePendingByUser($id_ketua);

            $bookingModel->commit();
            Flasher::setModalInfo('Booking Berhasil', 'Booking berhasil dibuat. Berhasil Buat Booking dari Admin kode: ' . $bookingCode ,'success');
            header("Location: /admin/buatPeminjaman");
            exit;

        } catch (\Throwable $e) {
            $bookingModel->rollBack();
            Flasher::setModalInfo('Booking gagal!', $e->getMessage(),'error');
            header('location: /admin/bookingRuangan/' . $id_room);
            exit();
        }
    }

    public function handleExternalBooking(){
        Flasher::modalInfo();

        // 1. Ambil Data dari Form
        $id_room        = $_POST['id_room'] ?? NULL;
        $email          = $_POST['email'] ?? NULL;
        $jumlah_orang   = $_POST['jumlah'] ?? 0;
        $instansi       = $_POST['instansi'] ?? NULL; // Ini akan jadi booker_name
        $tujuan         = $_POST['tujuan'] ?? NULL;
        $bookingDate    = $_POST['tanggalPinjam'] ?? NULL;
        $startTime      = $_POST['jamMulai'] ?? NULL;
        $endTime        = $_POST['jamSelesai'] ?? NULL;
        
        // File Upload
        $file_proposal  = $_FILES['file_proposal'] ?? NULL;

        // 2. Validasi Dasar (Kelengkapan Data)
        if (!$id_room || !$bookingDate || !$startTime || !$endTime || !$tujuan || !$instansi || !$email) {
            Flasher::setModalInfo('Gagal!', 'Semua field wajib diisi.', 'error');
            // Redirect kembali ke halaman form external
            header("Location: /Admin/bookingRuangRapat"); 
            exit;
        }

        if (!validateEmailPHP($email)) {
            Flasher::setModalInfo('Gagal!', 'Email Tidak Valid', 'error');
            header("Location: /Admin/bookingRuangRapat");
        }

        // Validasi File Upload Wajib Ada
        if ($file_proposal['error'] == 4) {
            Flasher::setModalInfo('Gagal!', 'Dokumen surat permohonan/proposal wajib diupload.', 'error');
            header("Location: /Admin/bookingRuangRapat");
            exit;
        }

        // 3. Persiapan Waktu
        $start_datetime = "$bookingDate $startTime";
        $end_datetime   = "$bookingDate $endTime";
        
        // Generate kode unik booking
        $bookingCode = generateBookingCode(8);

        // Load Models
        $bookingModel    = $this->model('BookingModel');
        $rescheduleModel = $this->model('RescheduleModel');

        try {
            $bookingModel->beginTransaction();

            // VALIDASI RUANGAN (CRITICAL)
            // Hanya ini pengecekan logikanya: Apakah ruangan kosong di jam itu?
            $cekRoom = $bookingModel->roomCheck($id_room, $end_datetime, $start_datetime);
            
            if ($cekRoom['total'] > 0) {
                throw new Exception("Mohon maaf, ruangan sudah ter-booking pada tanggal dan jam tersebut.");
            }

            // UPLOAD FILE
            // Menggunakan helper uploadDocument yang sudah dibuat sebelumnya
            // Pastikan path folder 'uploads/dokumen' sudah ada dan writable
            try {
                $namaFileDokumen = uploadDocument($file_proposal, 'storage/documents');
            } catch (Exception $uploadError) {
                throw new Exception($uploadError->getMessage());
            }


            // INSERT DATA
            $dataBooking = [
                'id_room'       => $id_room,
                'id_user'       => NULL,            // SET NULL karena Eksternal
                'booker_name'   => $instansi,       // Nama Peminjam = Nama Instansi
                'total_person'  => $jumlah_orang,   // Ambil langsung dari input
                'booking_code'  => $bookingCode,
                'start_time'    => $start_datetime,
                'end_time'      => $end_datetime,
                'email'         => $email,
                'agency'        => $instansi,
                'purpose'       => $tujuan,
                'document_path' => $namaFileDokumen,
                'status'        => 'pending'        // Biasanya external butuh approval admin
            ];

            // Create Booking
            $newBookingId = $bookingModel->createBooking($dataBooking);
            if (!$newBookingId) {
                throw new Exception("internal sql error");
            }

            // CLEANUP (Opsional)
            // Jika booking ini approve langsung (atau memblokir slot),
            // batalkan reschedule lain yang pending di jam yang sama.
            $rescheduleModel->autoCancelRescheduleConflict($id_room, $start_datetime, $end_datetime);

            $bookingModel->commit();
            
            Flasher::setModalInfo('Berhasil!', 'Permohonan booking terkirim. Silakan cek email secara berkala untuk info persetujuan.', 'success');
            header("Location: /admin/buatBooking"); // Atau halaman sukses
            exit;

        } catch (\Throwable $e) {
            $bookingModel->rollBack();

            // Hapus file jika database gagal save
            if (isset($namaFileDokumen)) {
                $filePath = dirname($_SERVER['DOCUMENT_ROOT']) . 'storage/documents/' . $namaFileDokumen;
                if (file_exists($filePath)) unlink($filePath);
            }

            Flasher::setModalInfo('Gagal Booking!', $e->getMessage(), 'error');
            header("Location: /admin/buatBooking");
            exit();
        }
    }

    public function startBooking()
    {
        // 1. Cek Request Method & Data
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_booking'])) {
            Flasher::setModalInfo('Error', 'Aksi tidak valid atau ID hilang.', 'error');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }

        $id_booking = $_POST['id_booking'];
        $bookingModel = $this->model('BookingModel');

        $bookingDetail = $bookingModel->getBookingById($id_booking);

        if (!$bookingDetail) {
            Flasher::setModalInfo('Error', 'Data booking tidak ditemukan.', 'error');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }

        // --- LOGIKA CEK WAKTU ---
        // Gunakan timezone yang sesuai (misal WIB)
        date_default_timezone_set('Asia/Jakarta'); 
        
        $waktuSekarang = time(); // Timestamp detik saat ini
        $waktuJadwal   = strtotime($bookingDetail['start_time']);

        // Toleransi waktu, boleh mulai 15 menit sebelum jadwal
        $toleransi = 15 * 60; // 15 menit dalam detik

        // Jika Waktu Sekarang < (Jadwal - Toleransi), maka tolak
        if ($waktuSekarang < ($waktuJadwal - $toleransi)) {
            Flasher::setModalInfo('Gagal', 'Belum waktunya mulai. Harap tunggu sesuai jadwal.', 'error');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }

        try {
            // Parameter ke-3 ($reason) tidak kita isi, jadi otomatis NULL (aman)
            $result = $bookingModel->updateStatusBooking($id_booking, 'ongoing');

            if ($result > 0) {
                Flasher::setModalInfo('Berhasil', 'Status berubah menjadi Berjalan (Ongoing).', 'success');
            } else {
                // Biasanya masuk sini kalau statusnya memang sudah 'ongoing' sebelumnya
                Flasher::setModalInfo('Info', 'Tidak ada perubahan status.', 'warning');
            }

            // 3. Redirect Balik ke Detail
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;

        } catch (Exception $e) {
            Flasher::setModalInfo('Gagal', 'Terjadi kesalahan sistem.', 'error');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }
    }

    public function finishBooking()
    {
        // 1. Cek Request Method & Data
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_booking'])) {
            Flasher::setModalInfo('Error', 'Aksi tidak valid atau ID hilang.', 'error');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }

        $id_booking = $_POST['id_booking'];
        $bookingModel = $this->model('BookingModel');

        try {
            // 2. Eksekusi Update ke 'completed'
            // (Atau 'done' / 'finished' sesuaikan dengan ENUM di databasemu)
            $result = $bookingModel->updateStatusBooking($id_booking, 'done');

            if ($result > 0) {
                Flasher::setModalInfo('Selesai', 'Peminjaman telah diselesaikan.', 'success');
            } else {
                Flasher::setModalInfo('Info', 'Status sudah selesai atau tidak berubah.', 'warning');
            }

            // 3. Redirect Balik ke Detail
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;

        } catch (Exception $e) {
            Flasher::setModalInfo('Gagal', 'Terjadi kesalahan sistem. ' . $e->getMessage() , 'error');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit;
        }
    }

    public function cancelBooking() {
        $bookingModel = $this->model('BookingModel');
        $rescheduleModel = $this->model('RescheduleModel');

        try {
            // Cek Input
            if (empty($_POST['id_booking'])) {
                throw new Exception("ID Booking tidak valid atau tidak ditemukan.", 1);
            }

            // Mulai Transaksi Database
            $bookingModel->beginTransaction();

            // atau fungsi cancelBooking di model (asal query-nya update status where id_booking only)
            $id_booking = $_POST['id_booking'];
            
            // Pastikan di BookingModel ada method ini yang WHERE-nya cuma id_booking
            $result = $bookingModel->updateStatusBooking($id_booking, 'cancelled'); 

            // Jika booking utama batal, reschedule yang 'pending' buat booking ini harus dianggap batal juga
            $rescheduleModel->cancelRescheduleByUser($id_booking);

            // Cek keberhasilan update
            if ($result <= 0) {
                throw new Exception("Gagal update database atau data tidak ditemukan", 1);
            }

            // Commit Transaksi (Simpan Permanen)
            $bookingModel->commit();

            Flasher::setModalInfo('Berhasil', 'Peminjaman berhasil dibatalkan oleh Admin.', 'success');
            
            // Redirect kembali ke detail atau halaman list
            header('Location: ' . BASEURL . '/admin/peminjaman?tab=riwayat' . $id_booking);
            exit();

        } catch (Throwable $e) {
            // Jika ada error, batalkan semua perubahan DB
            $bookingModel->rollback();
            
            Flasher::setModalInfo('Gagal', $e->getMessage(), 'error');
            header('Location: ' . BASEURL . '/admin/peminjaman');
            exit();
        }
    }

    public function updateTataTertib(){
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: /admin/ruangan");
                exit;
            }

            try {
                $id_announcement = $_POST['id_announcement'] ?? null;
                $tataTertib     = $_POST['tata_tertib'] ?? '';

                if (empty($id_announcement)) {
                    throw new Exception("ID pengumuman tidak ditemukan.");
                }

                $tataTertib = trim($tataTertib);

                if ($tataTertib === '') {
                    throw new Exception("Tata tertib tidak boleh kosong.");
                }

                $result = $this->model('AnnouncementModel')->updateAnnouncement($id_announcement, $tataTertib);

                if ($result <= 0) {
                    throw new Exception('Internal Server Error');
                }

                Flasher::setModalInfo('Berhasil', "Berhasil Update Tata Tertib", 'success');
                header("Location: /admin/announcement");
                exit;
            } catch (Exception $e) {
                Flasher::setModalInfo('Gagal', $e->getMessage(), 'error');
            }

            header("Location: /admin/ruangan");
            exit;
            
        }

    public function handleAddRoom(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/ruangan");
            exit;
        }

        try {
            
            if (empty($_POST['room_name']) || empty($_POST['floor']) || empty($_POST['status']) || empty($_POST['description']) || empty($_POST['short_description']) || empty($_POST['max_capacity']) || empty($_POST['min_capacity'])) {
                throw new Exception("Data tidak lengkap");
            }

            if ($_POST['max_capacity'] < $_POST['min_capacity']) {
                throw new Exception('isi yang bener kapasitas ruangannya');
            }

            // 4. Logika Upload Gambar
            $namaFileGambar = 'defaultRuangan.jpg'; // Gambar default jika user tidak upload

            // Cek apakah ada file yang diupload dan tidak ada error
            if (isset($_FILES['roomPhoto']) && $_FILES['roomPhoto']['error'] !== 4) {
                // Panggil helper 'uploadImage' yang kamu buat
                // Parameter 2: folder tujuan (tanpa slash di depan karena helper pakai trim)
                $namaFileGambar = uploadImage($_FILES['roomPhoto'], 'storage/roomsImage/');
                
            }

            // Susun Data untuk Model
            $data = [
                'room_name' => $_POST['room_name'],
                'floor' => $_POST['floor'],
                'status' => $_POST['status'],
                'min_capacity' => $_POST['min_capacity'],
                'max_capacity' => $_POST['max_capacity'],
                'description' => $_POST['description'],
                'short_description' => $_POST['short_description'],
                'img_room' => $namaFileGambar
            ];

            // Panggil Model untuk Insert Data
            // Asumsi nama method di model adalah 'tambahDataRuangan'
            $result = $this->model('RuanganModel')->createRoom($data);

            if ($result <= 0) {
                // Jika gagal insert, dan tadi upload gambar baru, hapus gambar yang sudah terlanjur diupload
                if ($namaFileGambar !== 'default.jpg' && file_exists('storage/roomsImage/' . $namaFileGambar)) {
                    unlink('storage/roomsImage/' . $namaFileGambar);
                }
                throw new Exception('Gagal menambahkan data ruangan ke database.');
            }

            // 7. Sukses
            Flasher::setModalInfo('Berhasil', "Ruangan berhasil ditambahkan", 'success');
            header("Location: /admin/ruangan");
            exit;

        } catch (Exception $e) {
            // 8. Error Handling
            Flasher::setModalInfo('Gagal', $e->getMessage(), 'error');
            // Redirect kembali ke halaman list atau form tambah (sesuaikan routingmu)
            header("Location: /admin/tambahDataRuangan"); 
            exit;
        }
    }

    public function handleUpdateRoom(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/ruangan");
            exit;
        }

        try {
            // 1. Validasi Input Dasar
            if (
                empty($_POST['id_room']) || 
                empty($_POST['room_name']) || 
                empty($_POST['floor']) || 
                empty($_POST['status']) || 
                empty($_POST['description']) || 
                empty($_POST['short_description']) || 
                empty($_POST['max_capacity']) || 
                empty($_POST['min_capacity'])
            ) {
                throw new Exception("Data tidak lengkap. Pastikan semua field terisi.");
            }

            // 2. Validasi Logika
            if ($_POST['max_capacity'] < $_POST['min_capacity']) {
                throw new Exception('Kapasitas maksimum tidak boleh lebih kecil dari minimum.');
            }

            // 3. Logika Upload Gambar (Update Version)
            // Ambil nama gambar lama dari input hidden di form
            $namaFileGambar = $_POST['old_roomPhoto']; 

            // Cek apakah user mengupload gambar BARU
            if (isset($_FILES['roomPhoto']) && $_FILES['roomPhoto']['error'] !== 4) {
                
                // Upload gambar baru
                $gambarBaru = uploadImage($_FILES['roomPhoto'], 'storage/roomsImage/');
                
                // Jika upload berhasil, set nama file baru
                if ($gambarBaru) {
                    $namaFileGambar = $gambarBaru;

                    // [OPSIONAL] Hapus gambar lama dari server jika bukan gambar default
                    // Pastikan kamu mengirim hidden input 'old_roomPhoto' di view
                    if ($_POST['old_roomPhoto'] !== 'defaultRuangan.jpg' && file_exists('storage/roomsImage/' . $_POST['old_roomPhoto'])) {
                        unlink('storage/roomsImage/' . $_POST['old_roomPhoto']);
                    }
                }
            }

            // 4. Susun Data untuk Model
            $data = [
                'id_room' => $_POST['id_room'], // ID untuk klausa WHERE
                'room_name' => $_POST['room_name'],
                'floor' => $_POST['floor'],
                'status' => $_POST['status'],
                'min_capacity' => $_POST['min_capacity'],
                'max_capacity' => $_POST['max_capacity'],
                'description' => $_POST['description'],
                'short_description' => $_POST['short_description'],
                'img_room' => $namaFileGambar // Bisa gambar baru, atau gambar lama
            ];

            // 5. Panggil Model Update
            // rowCount akan mengembalikan jumlah baris yang berubah.
            // Note: Jika data yang disave SAMA PERSIS dengan database, rowCount bisa 0.
            // Jadi kita hanya perlu cek apakah terjadi error SQL.
            $this->model('RuanganModel')->updateRoom($data);

            // 6. Sukses
            Flasher::setModalInfo('Berhasil', "Data ruangan berhasil diperbarui", 'success');
            header("Location: /admin/ruangan");
            exit;

        } catch (Exception $e) {
            // 7. Error Handling
            Flasher::setModalInfo('Gagal', $e->getMessage(), 'error');
            
            // Redirect kembali ke halaman edit dengan membawa ID (jika routing mendukung)
            // Atau kembali ke list
            header("Location: /admin/ruangan"); 
            exit;
        }
    }

public function handleDeleteRoom(){

    if (empty($_POST['id_room'])) {
        Flasher::setModalInfo('Gagal Hapus Ruangan', "Data tidak lengkap", 'error');
        header("Location: /admin/ruangan");
        exit;
    }

    try {
            // Inisialisasi Model
            $ruanganModel = $this->model('RuanganModel');
            $bookingModel = $this->model('BookingModel');
            $rescheduleModel = $this->model('RescheduleModel');

            // 1. Mulai Transaksi
            // (Pastikan class Database wrapper kamu support method beginTransaction)
            // $bookingModel->db->beginTransaction(); 

            // 2. Eksekusi Soft Delete Ruangan
            $deleted = $ruanganModel->deleteRoom($_POST['id_room']);

            // Kalau tidak ada baris yang berubah (misal ID salah), lempar Exception
            if ($deleted <= 0) {
                throw new Exception("Gagal menghapus ruangan atau ID tidak ditemukan.");
            }

            // 3. Eksekusi Cancel Booking & Reschedule (Otomatis)
            $canceledBookings = $bookingModel->cancelPendingBookingsByRoom($_POST['id_room']);
            $canceledReschedules = $rescheduleModel->cancelPendingReschedulesByRoom($_POST['id_room']);

            // 4. Commit (Simpan semua perubahan secara permanen)
            // $bookingModel->db->commit();

            // Siapkan pesan sukses
            $msg = "Ruangan berhasil dinonaktifkan.";
            if ($canceledBookings > 0 || $canceledReschedules > 0) {
                $total = $canceledBookings + $canceledReschedules;
                $msg .= " Sistem juga otomatis membatalkan $total reservasi pending terkait.";
            }

            Flasher::setModalInfo('Berhasil', $msg, 'success');

        } catch (Exception $e) {
            // 5. Rollback (Batalkan SEMUA perubahan jika terjadi error di langkah manapun)
            // Data ruangan akan kembali 'aktif' jika proses cancel booking error
            // $ruanganModel->db->rollBack();
            Flasher::setModalInfo('Gagal', $e->getMessage(), 'error');
        }

        // Redirect
        header("Location: /admin/ruangan");
        exit;
    }
}