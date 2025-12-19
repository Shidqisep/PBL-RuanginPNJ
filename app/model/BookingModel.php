<?php

class BookingModel {
    private $table = 'bookings';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    public function commit() {
        return $this->db->commit();
    }

    public function rollBack() {
        return $this->db->rollBack();
    }

    public function lastInsertId() {
        return $this->db->lastInsertId();
    }

    // Mengambil jadwal yang sudah ter-booking berdasarkan ruangan dan tanggal
    public function getBookingsByRoomAndDate($roomId, $date)
    {

    $query = "SELECT start_time, end_time 
              FROM " . $this->table . " 
              WHERE id_room = :id_room 
              AND DATE(start_time) = :date AND status NOT IN ('done', 'cancelled')";
    
    $this->db->query($query);
    $this->db->bind('id_room', $roomId);
    $this->db->bind('date', $date);
    
    return $this->db->resultSet();
    }

    //ini pengecekan apakah ada booking yang nabrak di rentang waktu segitu?
    public function roomCheck($id_room, $end_req, $start_req, $exclude_id = NULL){
        $query = "SELECT COUNT(*) as total FROM bookings WHERE id_room = :id_room
                  AND STATUS NOT IN ('rejected', 'cancelled', 'done')
                  AND (start_time < :end_req AND end_time > :start_req)";
        if ($exclude_id != NULL) {
        $query .= " AND id_booking != :exclude_id"; 
        }

        $this->db->query($query);
        $this->db->bind('id_room', $id_room);
        $this->db->bind('end_req', $end_req, PDO::PARAM_STR);
        $this->db->bind('start_req', $start_req, PDO::PARAM_STR);
        if ($exclude_id != NULL) {
        $this->db->bind('exclude_id', $exclude_id);
        }

        return $this->db->singleSet();
    }

    public function getAllBooking($bulan = [], $tahun = [])
    {
        // --- 1. NORMALISASI INPUT (pastikan array) ---
        if (!empty($bulan) && !is_array($bulan)) {
            $bulan = explode(',', $bulan); // ← penting kalau datang dari "2,1"
        }

        if (!empty($tahun) && !is_array($tahun)) {
            $tahun = explode(',', $tahun);
        }

        // --- 2. BASE QUERY ---
        $sql = "SELECT
                    b.id_booking,
                    u.username AS nama_penanggung_jawab,
                    r.room_name AS nama_ruangan,
                    b.start_time,
                    b.end_time,
                    b.status
                FROM bookings b
                JOIN users u ON b.id_user = u.id_user
                JOIN rooms r ON b.id_room = r.id_room
                WHERE 1=1";


        // --- 3. FILTER BULAN ---
        if (!empty($bulan)) {
            $inBulan = [];
            foreach ($bulan as $i => $b) {
                $inBulan[] = ":bulan$i"; // :bulan0, :bulan1
            }
            $sql .= " AND MONTH(b.start_time) IN (" . implode(',', $inBulan) . ")";
        }

        // --- 4. FILTER TAHUN ---
        if (!empty($tahun)) {
            $inTahun = [];
            foreach ($tahun as $i => $t) {
                $inTahun[] = ":tahun$i"; // :tahun0, :tahun1
            }
            $sql .= " AND YEAR(b.start_time) IN (" . implode(',', $inTahun) . ")";
        }

        // --- 5. ORDER ---
        $sql .= " ORDER BY b.start_time DESC";


        // --- 6. PREPARE QUERY ---
        $this->db->query($sql);


        // --- 7. BINDING (SESUAI PERMINTAAN: tetap 1–1) ---

        // Bind bulan
        if (!empty($bulan)) {
            foreach ($bulan as $i => $b) {
                $this->db->bind("bulan$i", intval($b));
            }
        }

        // Bind tahun
        if (!empty($tahun)) {
            foreach ($tahun as $i => $t) {
                $this->db->bind("tahun$i", intval($t));
            }
        }


        // --- 8. RETURN RESULT ---
        return $this->db->resultSet();
    }


    public function getBookingById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_booking = :id');
        
        // Binding data untuk mencegah SQL Injection
        $this->db->bind('id', $id);
        
        // Mengembalikan satu baris data saja (array associative)
        return $this->db->singleSet();
    }

    //ini buat bikin booking baru
    public function createBooking($data){

        $query = "INSERT INTO bookings (id_room, id_user,total_person, booking_code, start_time, end_time, status, external_email, institution_name, purpose, booking_letter, created_at) 
                  VALUES (:id_room, :id_user, :total_person, :booking_code, :start, :end, :status, :external_email, :institution_name, :purpose, :booking_letter, NOW())";
        
        $this->db->query($query);
        $this->db->bind('id_room', $data['id_room']);
        $this->db->bind('id_user', $data['id_user'] ?? NULL); // penanggung jawab
        $this->db->bind('total_person', $data['total_person']);
        $this->db->bind('booking_code', $data['booking_code']);
        $this->db->bind('start', $data['start_time'], PDO::PARAM_STR);
        $this->db->bind('end', $data['end_time'], PDO::PARAM_STR);
        $this->db->bind('status', $data['status'] ?? 'pending');
        $this->db->bind('external_email', $data['email'] ?? null);
        $this->db->bind('institution_name', $data['agency'] ?? null);
        $this->db->bind('purpose',       $data['purpose'] ?? null);
        $this->db->bind('booking_letter', $data['document_path'] ?? null);
        $this->db->execute();
        return $this->db->lastInsertId();  
    }

    public function getActiveBookingByUser($id_user){
    // Kita gunakan DISTINCT supaya jika ada join yang berulang, data booking tetap muncul sekali saja.
    // Kita pakai LEFT JOIN ke booking_members agar booking dimana dia jadi Ketua (dan mungkin tidak ada anggota) tetap termuat.
    
    $query = "SELECT DISTINCT b.id_booking, b.start_time FROM bookings b
              LEFT JOIN booking_members bm ON b.id_booking = bm.id_booking
              WHERE (b.id_user = :uid OR bm.id_user = :uid)
              AND b.status IN ('pending', 'ongoing')
              ORDER BY b.start_time ASC LIMIT 1";

    $this->db->query($query);
    $this->db->bind('uid', $id_user);
    
    return $this->db->singleSet();
    }

    public function getBookingIdByUser($id_user){
        // Kita gunakan DISTINCT supaya jika ada join yang berulang, data booking tetap muncul sekali saja.
        // Kita pakai LEFT JOIN ke booking_members agar booking dimana dia jadi Ketua (dan mungkin tidak ada anggota) tetap termuat.
        
        $query = "SELECT DISTINCT b.id_booking, b.start_time FROM bookings b
                LEFT JOIN booking_members bm ON b.id_booking = bm.id_booking
                WHERE (b.id_user = :uid OR bm.id_user = :uid)
                ORDER BY b.start_time DESC";

        $this->db->query($query);
        $this->db->bind('uid', $id_user);
    
        return $this->db->resultSet();
    }


public function getAllBookingByUser($id_user, $limit, $offset) {
        $sql = "SELECT DISTINCT b.id_booking, r.room_name, b.start_time, b.end_time,
                    b.total_person, b.status, b.created_at, f.rating
                FROM bookings b
                JOIN rooms r ON b.id_room = r.id_room
                LEFT JOIN booking_members bm ON b.id_booking = bm.id_booking
                LEFT JOIN feedback f ON b.id_booking = f.id_booking AND f.id_user = :id_user
                WHERE b.id_user = :id_user OR bm.id_user = :id_user
                ORDER BY b.start_time DESC
                LIMIT :limit OFFSET :offset";

        $this->db->query($sql);
        $this->db->bind('id_user', $id_user);
        $this->db->bind('limit', (int)$limit, PDO::PARAM_INT);
        $this->db->bind('offset', (int)$offset, PDO::PARAM_INT);

        return $this->db->resultSet();
    }


    public function countAllBookingByUser($id_user){
        $this->db->query("SELECT COUNT(DISTINCT b.id_booking) AS total
                        FROM bookings b
                        LEFT JOIN booking_members bm ON b.id_booking = bm.id_booking
                        WHERE b.id_user = :id_user OR bm.id_user = :id_user");
        $this->db->bind('id_user', $id_user);
        return $this->db->singleSet()['total'];
    }

    public function filterBookingByUser($id_user, $limit, $offset, $search = '', $status = '') {
            $sql = "SELECT DISTINCT b.id_booking, r.room_name, b.start_time, b.end_time,
                        b.total_person, b.status, b.created_at, f.rating
                    FROM bookings b
                    JOIN rooms r ON b.id_room = r.id_room
                    LEFT JOIN booking_members bm ON b.id_booking = bm.id_booking
                    LEFT JOIN feedback f ON b.id_booking = f.id_booking AND f.id_user = :id_user
                    WHERE (b.id_user = :id_user OR bm.id_user = :id_user)";

            // filter status
            if (!empty($status)) {
                if (!is_array($status)) {
                    $status = [$status];
                }

                $in = [];
                foreach ($status as $i => $s) {
                    $key = ":status$i";
                    $in[] = $key;
                }
                $sql .= " AND b.status IN (" . implode(',', $in) . ")";
            }

            // filter search
            if (!empty($search)) {
                $sql .= " AND (
                    r.room_name LIKE :search OR
                    b.status LIKE :search OR
                    b.total_person LIKE :search OR
                    DATE(b.start_time) LIKE :search
                )";
            }

            $sql .= " ORDER BY b.start_time DESC LIMIT :limit OFFSET :offset";

            $this->db->query($sql);
            $this->db->bind('id_user', $id_user);

            // bind status array
            if (!empty($status)) {
                foreach ($status as $i => $s) {
                    $this->db->bind("status$i", $s);
                }
            }

            if (!empty($search)) {
                $this->db->bind('search', "%$search%");
            }

            $this->db->bind('limit', (int)$limit, PDO::PARAM_INT);
            $this->db->bind('offset', (int)$offset, PDO::PARAM_INT);

            return $this->db->resultSet();
        }


        public function countFilterBookingByUser($id_user, $search = '', $status = '') {
        $sql = "SELECT COUNT(DISTINCT b.id_booking) AS total
                FROM bookings b
                JOIN rooms r ON b.id_room = r.id_room
                LEFT JOIN booking_members bm ON b.id_booking = bm.id_booking
                WHERE (b.id_user = :id_user OR bm.id_user = :id_user)";

            if (!empty($status)) {
                if (!is_array($status)) {
                    $status = [$status];
                }
                $in = [];
                foreach ($status as $i => $s) {
                    $in[] = ":status$i";
                }
                $sql .= " AND b.status IN (" . implode(',', $in) . ")";
            }

        if (!empty($search)) {
            $sql .= " AND (
                r.room_name LIKE :search OR
                b.status LIKE :search OR
                b.start_time LIKE :search OR
                b.end_time LIKE :search OR
                b.total_person LIKE :search OR
                DATE(b.start_time) LIKE :search
            )";
        }

        $this->db->query($sql);
        $this->db->bind('id_user', $id_user);

         if (!empty($status)) {
                foreach ($status as $i => $s) {
                    $this->db->bind("status$i", $s);
                }
            }

        if (!empty($search)) {
            $this->db->bind('search', "%$search%");
        }

        return $this->db->singleSet()['total'];
    }


    public function getActiveBookingJoinRoom($id_booking){
        $query = "SELECT b.id_booking, b.start_time, b.status, b.end_time, b.total_person, b.booking_code, r.room_name, r.img_room, r.short_description
                FROM bookings b JOIN rooms r ON b.id_room = r.id_room
                WHERE b.status IN ('pending', 'active', 'ongoing') AND b.id_booking = :id_booking";
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->execute();
        return $this->db->singleSet();
    }

        public function getAllActiveBookingJoinRoom(){
        $query = "SELECT b.id_booking, b.start_time, u.username, b.status, b.end_time, b.total_person, b.booking_code, r.room_name, r.short_description
                FROM bookings b 
                JOIN rooms r ON b.id_room = r.id_room
                JOIN users u ON b.id_user = u.id_user
                WHERE b.status = 'ongoing'";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //ini buat masukin anggota ke booking members
    public function insertBookingMember($id_booking, $id_user){
        $query = "INSERT INTO booking_members (id_booking, id_user)
                    VALUES (:id_booking, :id_user)";
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->bind('id_user', $id_user); 
        $this->db->execute();
        return $this->db->rowCount();
    }

    //ini buat ambil di reschedule
    //ini buat ambil di detailBooking admin juga
    public function getBookingMembers($id_booking){
    // Ambil NIM/NIP dan Nama dari tabel users lewat perantara booking_members
        $query = "SELECT u.id_user, u.username, u.nomor_induk
              FROM booking_members bm
              JOIN users u ON bm.id_user = u.id_user
              WHERE bm.id_booking = :id_booking";
              
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
    
        return $this->db->resultSet();
    }


    public function hasActiveBooking($id_user) {
        // Kita hapus filter range tanggal (start_time/end_time)
        // Kita hanya peduli statusnya: PENDING atau ONGOING
        $sql = "SELECT 1
                FROM bookings b
                LEFT JOIN booking_members bm 
                ON bm.id_booking = b.id_booking
                WHERE (b.id_user = :uid OR bm.id_user = :uid)
                AND b.status IN ('pending', 'ongoing')";

        $this->db->query($sql);
        $this->db->bind("uid", $id_user);

        // Jika ada hasil (row), berarti return TRUE (Punya booking aktif)
        return $this->db->singleSet() ? true : false;
    }

    // ini dia cek apakah dia ada booking minggu ini. ini dia per minggu
    public function checkUserQuota($id_user, $range_start, $range_end, $exclude_id = NULL){
        $sql = "SELECT 1
            FROM bookings b
            LEFT JOIN booking_members bm 
            ON bm.id_booking = b.id_booking
            WHERE (b.id_user = :uid OR bm.id_user = :uid)
                AND b.status IN ('pending', 'ongoing')
                AND (b.start_time < :range_end AND b.end_time > :range_start)";

            if ($exclude_id != NULL) {
            $sql .= " AND b.id_booking != :exclude_id";
            }

        $this->db->query($sql);
        $this->db->bind("uid", $id_user);
        $this->db->bind("range_start", $range_start);
        $this->db->bind("range_end", $range_end);  
            if ($exclude_id != NULL) {
            $this->db->bind("exclude_id", $exclude_id);
            } 

        return $this->db->singleSet() ? false : true;
    }


    //ini untuk reschedule dimana dia update total person dan juga schedulenya di tabel bookings
    public function updateScheduleAndTotalPerson($id_booking, $start, $end, $total){
        $query = "UPDATE bookings SET start_time = :start, end_time = :end, total_person = :total_person WHERE id_booking = :id_booking";
        $this->db->query($query);
        $this->db->bind('start', $start);
        $this->db->bind('end', $end);
        $this->db->bind('total_person', $total);
        $this->db->bind('id_booking', $id_booking);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function clearBookingMembers($id_booking) {
        $query = "DELETE FROM booking_members WHERE id_booking = :id";
        $this->db->query($query);
        $this->db->bind('id', $id_booking);
        $this->db->execute();
    }

    public function importMembersFromReschedule($id_booking, $id_reschedule) {
        $query = "INSERT INTO booking_members (id_booking, id_user)
                  SELECT :id_booking, id_user 
                  FROM reschedule_members 
                  WHERE id_reschedule = :id_res";
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->bind('id_res', $id_reschedule);
        $this->db->execute();
    }


    public function cancelBooking($id_booking){
        $query = "UPDATE bookings SET status = 'cancelled', cancel_by = 'user' WHERE id_booking = :id_booking";
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateStatusBooking($id_booking, $status, $reason = NULL) {
        
        $query = "UPDATE bookings SET status = :status, reject_reason = :reason
                WHERE id_booking = :id_booking";

        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('reason', $reason ?? NULL);
        $this->db->bind('id_booking', $id_booking);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function filterBookings($limit, $start, $search = '', $status = [], $dateMode = '')
    {
        // Base Query dengan JOIN User & Room
        $sql = "SELECT b.*, r.room_name, u.username
                FROM bookings b
                JOIN rooms r ON b.id_room = r.id_room
                LEFT JOIN users u ON b.id_user = u.id_user
                WHERE 1=1";

        // 1. FILTER DATE MODE (Kunci Logic Tab)
        if ($dateMode == 'today') {
            // Khusus Tab Hari Ini
            $sql .= " AND DATE(b.start_time) = CURDATE()";
        } 
        elseif ($dateMode == 'upcoming') {
            // Khusus Tab Berlangsung (Booking masa depan atau sedang jalan)
            // Dan status bukan selesai/batal (opsional, tergantung logic kamu)
            $sql .= " AND b.end_time >= NOW()"; 
        }
        // elseif ($dateMode == 'history') { ... logic lain jika perlu ... }

        // 2. FILTER STATUS (Dynamic IN)
        if (!empty($status)) {
            if (!is_array($status)) $status = [$status];
            $in = [];
            foreach ($status as $i => $s) {
                $in[] = ":status$i";
            }
            $sql .= " AND b.status IN (" . implode(',', $in) . ")";
        }

        // 3. FILTER SEARCH
        if (!empty($search)) {
            $sql .= " AND ( 
                        u.username LIKE :search OR 
                        r.room_name LIKE :search OR 
                        b.booking_code LIKE :search OR
                        b.start_time LIKE :search
                    )";
        }

        // 4. ORDER & LIMIT
        $sql .= " ORDER BY b.start_time DESC LIMIT :limit OFFSET :start";

        $this->db->query($sql);

        // 5. BINDING
        if (!empty($status)) {
            foreach ($status as $i => $s) {
                $this->db->bind("status$i", $s);
            }
        }
        if (!empty($search)) {
            $this->db->bind('search', "%$search%");
        }
        
        $this->db->bind('limit', (int)$limit, PDO::PARAM_INT);
        $this->db->bind('start', (int)$start, PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    // Function Count-nya (Wajib Ada)
    public function countFilterBookings($search = '', $status = [], $dateMode = '')
    {
        $sql = "SELECT COUNT(*) as total 
                FROM bookings b
                JOIN rooms r ON b.id_room = r.id_room
                LEFT JOIN users u ON b.id_user = u.id_user
                WHERE 1=1";

        if ($dateMode == 'today') {
            $sql .= " AND DATE(b.start_time) = CURDATE()";
        } elseif ($dateMode == 'upcoming') {
            $sql .= " AND b.end_time >= NOW()";
        }

        if (!empty($status)) {
            if (!is_array($status)) $status = [$status];
            $in = [];
            foreach ($status as $i => $s) {
                $in[] = ":status$i";
            }
            $sql .= " AND b.status IN (" . implode(',', $in) . ")";
        }

        if (!empty($search)) {
            $sql .= " AND (u.username LIKE :search OR r.room_name LIKE :search OR b.booking_code LIKE :search)";
        }

        $this->db->query($sql);

        if (!empty($status)) {
            foreach ($status as $i => $s) {
                $this->db->bind("status$i", $s);
            }
        }
        if (!empty($search)) {
            $this->db->bind('search', "%$search%");
        }

        $result = $this->db->singleSet();
        return $result['total'];
    }

    public function countBookingPending() {
        $this->db->query("SELECT COUNT(*) AS total FROM bookings WHERE status = 'pending'");
        return $this->db->singleSet()['total'];
    }

    public function getBookingDoneAndCancelledjoinRoom($limit, $offset) {
        $query = "SELECT b.id_booking, u.username, b.start_time, 
                b.end_time, b.booking_code, b.status, 
                r.room_name
            FROM bookings b 
            JOIN rooms r ON b.id_room = r.id_room
            JOIN users u ON b.id_user = u.id_user
            WHERE b.status IN ('done', 'cancelled')
            ORDER BY b.start_time DESC
            LIMIT :limit OFFSET :offset
        ";

        $this->db->query($query);
        $this->db->bind('limit', (int)$limit);
        $this->db->bind('offset', (int)$offset);

        return $this->db->resultSet();
    }

    public function countBookingDoneAndCancelled() {
        $this->db->query("SELECT COUNT(*) AS total FROM bookings WHERE status IN ('done', 'cancelled')");
        return $this->db->singleSet()['total'];
    }



    public function getBookingByIdAndUser($id_booking, $id_user){
        // Ambil data booking DAN data ruangan sekaligus
        $query = "SELECT b.*, r.room_name, r.min_capacity, max_capacity, r.description, r.img_room, r.floor
              FROM bookings b
              JOIN rooms r ON b.id_room = r.id_room
              WHERE b.id_booking = :id_booking 
              AND b.id_user = :id_user";
              
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->bind('id_user', $id_user);
    
        return $this->db->singleSet();
    }

    public function isUserAssociatedWithBooking($id_booking, $id_user) {
        // Query untuk mengecek apakah user adalah PEMBUAT atau ANGGOTA dari booking tersebut
        $query = "SELECT b.id_booking 
                FROM bookings b
                LEFT JOIN booking_members bm ON b.id_booking = bm.id_booking
                WHERE b.id_booking = :id_booking 
                AND (b.id_user = :id_user OR bm.id_user = :id_user)
                LIMIT 1";

        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->bind('id_user', $id_user);
        
        // Jika ada hasil, berarti user berhak. Jika false/kosong, berarti tidak berhak.
        return $this->db->singleSet(); 
    }

    public function getBookingDetail($id_booking) {
        $query = "SELECT b.id_booking, b.booking_code, b.start_time, b.end_time, b.status, b.external_email,
                    b.purpose, b.institution_name, b.booking_letter, r.room_name, r.min_capacity, r.max_capacity, r.floor, r.description, 
                    u.username, u.jurusan_unit, u.nomor_induk,
                    IFNULL(AVG(f.rating), 0) AS avg_rating,
                    COUNT(f.id_feedback) AS total_review
                FROM bookings b
                JOIN rooms r ON b.id_room = r.id_room 
                LEFT JOIN users u ON b.id_user = u.id_user
                LEFT JOIN bookings b2 ON r.id_room = b2.id_room
                LEFT JOIN feedback f ON b2.id_booking = f.id_booking
                WHERE b.id_booking = :id_booking
                GROUP BY b.id_booking";

        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        
        // Gunakan single() karena id_booking itu primary key (pasti cuma 1 data)
        return $this->db->singleSet(); 
    }

    public function cancelPendingBookingsByRoom($id_room){
        $query = "UPDATE bookings 
                SET status = 'cancelled', 
                    cancel_by = 'system' 
                WHERE id_room = :id_room 
                AND status = 'pending'";

        $this->db->query($query);
        $this->db->bind('id_room', $id_room);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getAllBookingFiltered($limit, $start, $ruangan = [], $bulan = [], $tahun = [])
    {
        // Query Dasar
        $query = "SELECT b.id, u.name as nama_peminjam, r.name as nama_ruangan, b.start_time, b.end_time, b.status 
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN rooms r ON b.room_id = r.id 
                WHERE 1=1 "; // Trik agar bisa nambahin AND secara dinamis

        // Tambah Filter Ruangan (Jika ada)
        if (!empty($ruangan)) {
            // Mengubah array menjadi string dipisah koma, cth: 'Ruang A','Ruang B'
            $ruanganStr = implode("','", $ruangan); 
            $query .= " AND r.name IN ('$ruanganStr')";
        }

        // Tambah Filter Bulan
        if (!empty($bulan)) {
            $bulanStr = implode(",", $bulan);
            $query .= " AND MONTH(b.start_time) IN ($bulanStr)";
        }

        // Tambah Filter Tahun
        if (!empty($tahun)) {
            $tahunStr = implode(",", $tahun);
            $query .= " AND YEAR(b.start_time) IN ($tahunStr)";
        }

        // Order dan Limit (Wajib di akhir)
        $query .= " ORDER BY b.start_time DESC LIMIT :limit OFFSET :offset";

        $this->db->query($query);
        $this->db->bind('limit', $limit);
        $this->db->bind('offset', $start);
        
        return $this->db->resultSet();
    }
    

    public function autoCancelLateBookings()
    {
        
        $query = "UPDATE bookings b
                    LEFT JOIN reschedule r ON r.id_booking = b.id_booking
                    SET 
                        b.status = 'cancelled',
                        b.cancel_by = 'system',
                        r.cancel_by = 'system',
                        r.status_reschedule = CASE 
                            WHEN r.status_reschedule = 'pending' THEN 'cancelled'
                            ELSE r.status_reschedule
                        END
                    WHERE b.status = 'pending'
                    AND NOW() > DATE_ADD(b.start_time, INTERVAL 10 MINUTE);";
                  
        $this->db->query($query);
        $this->db->execute();
        
        // Mengembalikan jumlah baris yang di-update
        return $this->db->rowCount();
    }

    public function getLateBookings(){
        $query = "SELECT b.id_booking, b.booking_code, b.start_time, u.username, u.id_user
                  FROM bookings b
                  JOIN users u ON b.id_user = u.id_user
                  WHERE b.status = 'pending'
                  AND NOW() > DATE_ADD(b.start_time, INTERVAL 10 MINUTE)";
        
        $this->db->query($query);
        return $this->db->resultSet();  
    }

    public function cancelBookingSystem($id_booking)
    {
        $query = "UPDATE bookings SET status = 'cancelled', cancel_by = 'system' WHERE id_booking = :id_booking";
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->execute();
        return $this->db->rowCount();
    }



    public function autoCompleteFinishedBookings()
    {
        //ini untuk mengubah status ke done saat dia masih ongoing
        $query = "UPDATE " . $this->table . " 
                  SET status = 'done' 
                  WHERE status = 'ongoing' 
                  AND NOW() > end_time";

        $this->db->query($query);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

}