<?php

class Booking extends Controller {

    public function __construct()
        {
            parent::__construct();
            if (!isset($_SESSION['user'])) {
            // Jika 'user_id' tidak ada di session (artinya belum login)
            Flasher::setModalInfo('Anda harus login', 'untuk mengakses halaman ini.', 'error');
            header('Location: /auth/formLogin'); // Redirect ke halaman login
            exit; //Hentikan eksekusi script
            }

            $user = $this->model('UserModel')->getSuspendCount($_SESSION['user']['user_id']);

            if ($user >= 3) {
                Flasher::setModalInfo('Suspend_count anda < 3 hayoo looo', 'silahkan hubungi admin', 'error');
                session_destroy();
                header('Location: /auth/formLogin'); // Redirect ke halaman login

                exit;
            }
        }

    // public function index()
    //{
        
    //     $data['judul'] = 'History';
    //     $data['navbar'] = 'History';
    //     $this->view('Layout/Header', $data);
    //     $this->view('anggota/History/index', $data); 
    //     $this->view('Layout/Footer');
    // }

    public function index(){

        // ?: katanya bisa nangkep false coy

        $data['booking'] = $this->model('BookingModel')->getActiveBookingByUser($_SESSION['user']['user_id']) ?: [];
        $bookingId = $data['booking']['id_booking'] ?? null;

        //biar ga error pas di view
        $data['activeBooking'] = [];
        $data['reschedule'] = null; // Default null
        $data['currentTab'] = $_GET['tab'] ?? 'booking'; // Default tab 'booking'

        if ($bookingId) {   
        //selalu ambil detail booking lengkap (Join Room) 
        //Alasannya: Di tab reschedule pun, kamu mungkin butuh info "Reschedule untuk Ruang Apa & Jam Berapa"
            $data['activeBooking'] = $this->model('BookingModel')->getActiveBookingJoinRoom($bookingId);
        }
        if ($data['currentTab'] === 'reschedule') {
                // $data['reschedules'] = $this->model('RescheduleModel')->getAllRescheduleByIdUser($);
                $data['reschedules'] = $this->model('RescheduleModel')->getAllRescheduleByIdUser($_SESSION['user']['user_id']);
        }

        if ($data['activeBooking']){
            $data['bookingDate'] = tanggal_indonesia($data['activeBooking']['start_time']);
            $data['start_time'] = date('H:i', strtotime($data['activeBooking']['start_time']));
            $data['end_time'] = date('H:i', strtotime($data['activeBooking']['end_time']));
            $data['status'] = translateStatus($data['activeBooking']['status']);
        } else {
            $data['bookingDate'] = '';
            $data['start_time'] = '';
            $data['end_time'] = '';
            $data['status'] = '';
        }
        $data['judul'] = 'Booking Anda';
        $data['navbar'] = 'bookingAnda';
        $this->view('Layout/Header', $data);
        $this->view('anggota/bookingAnda/index', $data); 
        $this->view('Layout/Footer');
    }

    
    
    // Endpoint untuk mengecek jadwal (dipanggil via fetch/AJAX)
    public function cekJadwal()
    {
        // Mengambil data JSON dari request body
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['room_id']) || !isset($input['date'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Parameter tidak lengkap']);
            exit;
        }

        $roomId = $input['room_id'];
        $date = $input['date'];

        // Panggil BookingModel yang baru kita buat
        $bookedSlots = $this->model('BookingModel')->getBookingsByRoomAndDate($roomId, $date);

        // Kembalikan data sebagai JSON
        header('Content-Type: application/json');
        echo json_encode($bookedSlots);
        exit;
    }

    public function cariAnggota(){
    // Ambil data JSON dari fetch
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $nomor_induk = $data['nim'] ?? '';
    if (empty($nomor_induk)) {
        echo json_encode(['error' => 'NIM kosong']);
        return;
    }

    // Panggil Model untuk cari user
    $user = $this->model('UserModel')->getUserByNomor_IndukActive($nomor_induk);

    // Kembalikan JSON
        header('Content-Type: application/json');
        if ($user) {
            echo json_encode(['nama' => $user['username']]);
        } else {
            echo json_encode(['nama' => null]);
        }
    }

    public function handleBooking(){
        Flasher::modalInfo();

        $id_room = $_POST['id_room'] ?? NULL;
        $bookingDate = $_POST['tanggalPinjam']?? NULL;
        $startTime = $_POST['jamMulai']?? NULL;
        $endTime = $_POST['jamSelesai']?? NULL;

        if (!$id_room || !$bookingDate || !$startTime || !$endTime) {
            Flasher::setModalInfo('Gagal!', 'Semua field wajib diisi', 'error');
            header("Location: /dashboard");
        exit;
        }


        if (!isset($_POST['nim']) || !is_array($_POST['nim'])) {
            // Handle jika tidak ada input NIM sama sekali
            Flasher::setModalInfo('Gagal!', 'Data anggota tidak valid', 'error');
            header("Location: /dashboard");
            exit;
        }

        $nomorIndukKetua = $_POST['nim'][0];
        $list_nim_anggota = array_slice($_POST['nim'], 1); 

        
        $start_datetime = "$bookingDate $startTime";
        $end_datetime   = "$bookingDate $endTime";

        $ts = strtotime($bookingDate);

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

            if ($bookingModel->hasActiveBooking($userKetua['id_user'])) {
                throw new Exception('Anda masih memiliki peminjaman yang sedang berjalan/pending. Selesaikan dulu sebelum meminjam lagi.');
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
                if ($bookingModel->hasActiveBooking($userAnggota['id_user'])) {
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
            Flasher::setModalInfo('Booking Berhasil', 'Booking berhasil dibuat. Jangan telat yaa','success');
            header("Location: /dashboard");
            exit;

        } catch (\Throwable $e) {
            $bookingModel->rollBack();
            Flasher::setModalInfo('Booking gagal!', $e->getMessage(),'error');
            header('location: /dashboard');
            exit();
        }
    }

    public function cancelBooking(){

        $bookingModel = $this->model('BookingModel');
        $userModel = $this->model('UserModel');
        $rescheduleModel = $this->model('RescheduleModel');

        try{
            if (empty($_POST['id_booking']) || empty($_SESSION['user']['user_id'])) {
                throw new Exception("id_booking tidak valid", 1);
            }
        $bookingModel->beginTransaction();

        //ini dia update status ke cancelled
        $existingBooking = $bookingModel->getBookingByIdAndUser($_POST['id_booking'], $_SESSION['user']['user_id']);
        if (!$existingBooking) {
            throw new Exception('Hanya ketua yang bisa membatalkan peminjaman!');
        }
        $result = $bookingModel->cancelBooking($_POST['id_booking']);
        //menambahkan suspend ke user
        $suspend = $userModel->addSuspendCount($_SESSION['user']['user_id']);
        //ini dia nge cancel atau nge declined reschedule yang masih pending (kalo ada)
        $rescheduleModel->cancelRescheduleByUser($_POST['id_booking']);

            if ($result <= 0 || $suspend <= 0 || $suspend <= 0) {
                throw new Exception("internal server error", 1);
            }

        $bookingModel->commit();
        Flasher::setModalInfo('Cancel Peminjaman Berhasil', 'Peminjaman berhasil dibatalkan', 'success');
        header('location: /dashboard');
        exit();

        }catch(Throwable $e){
            $bookingModel->rollback();
            Flasher::setModalInfo('Gagal Membatalkan Booking', $e->getMessage(), 'error');
            header('location: /Booking');
            exit();
        }
    }

    public function Reschedule($id_booking = NULL) {

        $id_booking = param_number($id_booking);

        if ($id_booking === false || $id_booking < 1) {
            Flasher::setModalInfo('Parameter Salah', 'hayooo ubah-ubah parameter yaa?', 'error');
            header('Location: /booking'); // Redirect ke halaman booking
            exit;
        }

        if ($this->model('RescheduleModel')->getRescheduleByBookingId($id_booking)) {
            Flasher::setModalInfo('Gagal Reschedule', 'booking ini sudah pernah di reschedule', 'error');
            header('Location: /booking'); // Redirect ke halaman booking
            exit;
        }

        $data['detailRuangan'] = $this->model('BookingModel')->getBookingByIdAndUser($id_booking, $_SESSION['user']['user_id']);
        $bookingData = $data['detailRuangan'];
        if (!$bookingData) {
        // Jika data kosong, berarti booking itu tidak ada, ATAU user bukan penanggung jawab booking ini
        
        // ampilkan pesan error pake Flasher
        Flasher::setModalInfo('Gagal reschedule', 'Anda tidak memiliki akses ke booking ini, hanya penanggung jawab yang bisa reschedule', 'error');
        header('Location: ' . BASEURL . '/Booking');
        exit;
        }

        if ($bookingData['status'] == 'done' || $bookingData['status'] == 'cancelled' || $bookingData['status'] == 'ongoing') {
         Flasher::setFlash('Gagal', 'Booking yang sudah selesai/batal tidak bisa di-reschedule.', 'error');
         header('Location: ' . BASEURL . '/Booking');
         exit;
        }

        $data['members'] = $this->model('BookingModel')->getBookingMembers($id_booking);

        $data['user'] = $_SESSION['user'];
        $data['navbar'] = 'bookingAnda';
        $data['judul'] = 'Reschedule';
        $this->view('Layout/Header', $data);
        $this->view('anggota/bookingAnda/reschedule', $data); 
        $this->view('Layout/Footer');
    }



    public function handleReschedule(){
        $id_booking = $_POST['id_booking'] ?? NULL;
        $newDate    = $_POST['tanggalBaru'] ?? NULL; // Pastikan name di view sesuai
        $newStart   = $_POST['jamMulai'] ?? NULL;
        $newEnd     = $_POST['jamSelesai'] ?? NULL;
        // $reason     = $_POST['alasan'] ?? 'none';
        $nim_list   = $_POST['nim'] ?? []; // Array NIM Anggota


    // 2. Validasi Dasar
        if (!$id_booking || !$newDate || !$newStart || !$newEnd) {
            Flasher::setModalInfo('Gagal!', 'Semua field wajib diisi (Tanggal, Jam, Alasan)', 'error');
            header("Location: /Booking/Reschedule/$id_booking");
            exit;
        }

        $new_start_datetime = "$newDate $newStart";
        $new_end_datetime   = "$newDate $newEnd";
        $ts = strtotime($newDate);

        $range_start = date('Y-m-d 00:00:00', strtotime('monday this week', $ts));
        $range_end   = date('Y-m-d 23:59:59', strtotime('sunday this week', $ts));

    // Hitung Range Mingguan (Untuk cek kuota di tanggal baru)
        $ts = strtotime($newDate);
        // $range_start = date('Y-m-d 00:00:00', strtotime('monday this week', $ts));
        // $range_end   = date('Y-m-d 23:59:59', strtotime('sunday this week', $ts));

        $bookingModel = $this->model('BookingModel');
        $rescheduleModel = $this->model('RescheduleModel');
        $userModel    = $this->model('UserModel');


        try {
        $bookingModel->beginTransaction();

        // -----------------------------------------------------------
        // STEP A: Validasi Booking Lama
        // -----------------------------------------------------------
        // Cek apakah booking ini benar milik user yang login?
        $existingBooking = $bookingModel->getBookingByIdAndUser($id_booking, $_SESSION['user']['user_id']);
        if (!$existingBooking) {
            throw new Exception('Data booking tidak ditemukan atau akses ditolak.');
        }

        $existingReschedule = $rescheduleModel->getActiveRescheduleByBookingId($id_booking);

        if ($existingReschedule) {
            if ($existingReschedule['status_reschedule'] == 'pending') {
                throw new Exception("Booking ini sedang dalam proses reschedule (Status: Pending). Tunggu konfirmasi admin.");
            } else {
                throw new Exception("Booking ini sudah berhasil di-reschedule sebelumnya. Tidak dapat diubah lagi.");
            }
        }

        // -----------------------------------------------------------
        // STEP B: Cek Ketersediaan Ruangan di Jam BARU
        // -----------------------------------------------------------
        // Kita cek apakah ruangan tersebut kosong di jam yang baru diminta
        $cekRoom = $bookingModel->roomCheck($existingBooking['id_room'], $new_end_datetime, $new_start_datetime);
        
        if ($cekRoom['total'] > 0) {
             // Opsional: Cek apakah yang bentrok itu diri sendiri (kalau geser jam dikit)?
             // Tapi karena ini request reschedule baru, amannya anggap bentrok.
             throw new Exception("Ruangan sudah terisi pada jadwal baru yang dipilih.");
        }

        //belom ada cek user apakah dia ada booking aktif atau tidak?

        // apakah ini perlu?
        // STEP C: Cek Kuota Ketua di Minggu BARU
        // 
        // Jika pindah minggu, harus cek kuota lagi. Jika minggu sama, sebenernya aman, 
        // tapi kita cek saja untuk konsistensi.
        // NOTE: Kita skip cek ini jika status reschedule 'pending' tidak memakan kuota, 
        // tapi kalau mau strict, nyalakan baris di bawah ini:
        /*
        if (!$bookingModel->checkUserQuota($currentUserId, $range_start, $range_end)) {
             throw new Exception('Kuota mingguan Anda sudah habis di tanggal baru tersebut.');
        }
        */

        // Validasi Anggota (Looping NIM)

        $validatedMembers = [];

        foreach ($nim_list as $nim) {
            $nim = trim($nim);
            if (empty($nim)) continue;

            // Cek User Exist
            $userAnggota = $userModel->getUserByNomor_Induk($nim);
            if (!$userAnggota) throw new Exception("NIM Anggota ($nim) tidak terdaftar.");

            // Jangan masukkan ketua sebagai anggota
            if ($userAnggota['id_user'] == $_SESSION['user']['user_id']) continue;

            //logika nya salah ini
            if (!$bookingModel->checkUserQuota($userAnggota['id_user'], $range_start, $range_end, $id_booking)) {
                    throw new Exception("Anggota (" . $userAnggota['username'] . ") sudah ada jadwal minggu ini.");
                }

            if ($rescheduleModel->checkUserHasReschedule($userAnggota['id_user'])) {
                    throw new Exception("Anggota (" . $userAnggota['username'] . ") sudah ada di anggota reschedule orang lain.");
                }

            $validatedMembers[] = $userAnggota['id_user'];
        }
        
        // Insert ke tabel `reschedule`
        $rescheduleData = [
            'id_booking'        => $id_booking,
            'new_start_time'    => $new_start_datetime,
            'new_end_time'      => $new_end_datetime,
            'status_reschedule' => 'pending' // Default pending
        ];

        // Kamu perlu buat method ini di BookingModel
        $newRescheduleId = $rescheduleModel->createReschedule($rescheduleData);

        // 2. Insert ke tabel `reschedule_members`
        foreach ($validatedMembers as $id_member) {
            // Kamu perlu buat method ini di BookingModel
            $rescheduleModel->insertRescheduleMember($newRescheduleId, $id_member);
        }

        // Sukses
        $rescheduleModel->commit();
        Flasher::setModalInfo('Berhasil!', 'Pengajuan reschedule terkirim. Tunggu persetujuan admin.', 'success');
        header("Location: /Booking/index?tab=reschedule");
        exit;

    } catch (\Throwable $e) {
        $rescheduleModel->rollBack();
        Flasher::setModalInfo('Gagal Reschedule!', $e->getMessage(), 'error');
        header("Location: /Booking/Reschedule/$id_booking");
        exit;
    }
    }

}