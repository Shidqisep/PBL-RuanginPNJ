<?php

class DashboardModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getBookingStats($bulan = null, $tahun = null)
    {
        // --- 1. NORMALISASI INPUT ---
        // Pastikan input selalu berbentuk array agar logikanya seragam
        // Jika null/kosong, set jadi array kosong. Jika single value, bungkus jadi array.
        if (!empty($bulan) && !is_array($bulan)) {
            $bulan = [$bulan];
        }
        if (!empty($tahun) && !is_array($tahun)) {
            $tahun = [$tahun];
        }

        // --- 2. PERSIAPAN FILTER (DYNAMIC BINDING) ---
        $conditions = [];
        $params = [];

        // Logika Filter Bulan (Menggunakan IN)
        if (!empty($bulan)) {
            $bulanPlaceholders = [];
            foreach ($bulan as $key => $val) {
                $placeholder = ":bulan_" . $key; // bikin nama unik misal :bulan_0, :bulan_1
                $bulanPlaceholders[] = $placeholder;
                $params[$placeholder] = $val;
            }
            // Hasil string: MONTH(start_time) IN (:bulan_0, :bulan_1)
            $conditions[] = "MONTH(start_time) IN (" . implode(', ', $bulanPlaceholders) . ")";
        }

        // Logika Filter Tahun (Menggunakan IN)
        if (!empty($tahun)) {
            $tahunPlaceholders = [];
            foreach ($tahun as $key => $val) {
                $placeholder = ":tahun_" . $key;
                $tahunPlaceholders[] = $placeholder;
                $params[$placeholder] = $val;
            }
            $conditions[] = "YEAR(start_time) IN (" . implode(', ', $tahunPlaceholders) . ")";
        }

        // Gabungkan kondisi WHERE jika ada
        $whereClause = "";
        if (!empty($conditions)) {
            $whereClause = " WHERE " . implode(" AND ", $conditions);
        }

        // --- 3. QUERY UTAMA (BOOKINGS) ---
        $query = "SELECT 
                    COUNT(*) AS total_booking,
                    SUM(CASE WHEN status = 'ongoing' THEN 1 ELSE 0 END) AS dipinjam,
                    SUM(CASE WHEN status = 'done' THEN 1 ELSE 0 END) AS selesai,
                    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) AS dibatalkan
                FROM bookings" . $whereClause;

        $this->db->query($query);
        
        // Binding parameter dinamis
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        
        $bookingData = $this->db->singleSet();


        // --- 4. QUERY KEDUA (RESCHEDULE) ---
        // Kita gunakan $whereClause dan $params yang SAMA persis
        // Karena filternya juga berdasarkan waktu booking asli
        
        $queryReschedule = "SELECT COUNT(*) as total_reschedule 
                            FROM reschedule r
                            JOIN bookings b ON r.id_booking = b.id_booking" . $whereClause;
        
        $this->db->query($queryReschedule);
        
        // Binding ulang parameter (karena ini query baru)
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        
        $rescheduleData = $this->db->singleSet();

        // Gabungkan hasil
        $bookingData['reschedule'] = $rescheduleData['total_reschedule'];
        
        return $bookingData;
    }

    // -----------------------------------------------------------
    // 2. STATISTIK ANGGOTA (Tetap sama seperti sebelumnya)
    // -----------------------------------------------------------
    public function getUserStats($jurusanFilter = [], $prodiFilter = [])
    {
        // Asumsi relasi user -> role
        $query = "SELECT 
                    COUNT(*) AS total_anggota,
                    SUM(CASE WHEN r.role_name = 'Dosen' THEN 1 ELSE 0 END) AS total_dosen,
                    SUM(CASE WHEN r.role_name = 'Mahasiswa' THEN 1 ELSE 0 END) AS total_mahasiswa,
                    SUM(CASE WHEN r.role_name = 'Tendik' THEN 1 ELSE 0 END) AS total_tendik,
                    SUM(CASE WHEN u.status = 'active' THEN 1 ELSE 0 END) AS aktif,
                    SUM(CASE WHEN u.status = 'rejected' THEN 1 ELSE 0 END) AS ditolak,
                    SUM(CASE WHEN u.status = 'pending' THEN 1 ELSE 0 END) AS menunggu
                  FROM users u
                  LEFT JOIN roles r ON u.id_role = r.id_role
                  WHERE 1=1";

        if (!empty($jurusanFilter)) {
            $placeholders = [];
            foreach ($jurusanFilter as $key => $val) {
                $placeholders[] = ":jurusan_$key";
            }
            $query .= " AND u.jurusan_unit IN (" . implode(',', $placeholders) . ")";
        }

        if (!empty($prodiFilter)) {
            $placeholders = [];
            foreach ($prodiFilter as $key => $val) {
                $placeholders[] = ":prodi_$key";
            }
            $query .= " AND u.prodi_unit IN (" . implode(',', $placeholders) . ")";
        }

        $this->db->query($query);

        if (!empty($jurusanFilter)) {
            foreach ($jurusanFilter as $key => $val) {
                $this->db->bind(":jurusan_$key", $val);
            }
        }

        if (!empty($prodiFilter)) {
            foreach ($prodiFilter as $key => $val) {
                $this->db->bind(":prodi_$key", $val);
            }
        }

        return $this->db->singleSet();
    }

    // -----------------------------------------------------------
    // 3. STATISTIK RUANGAN (Updated dengan tabel Feedback)
    // -----------------------------------------------------------
    public function getRoomStats($bulan = null, $tahun = null)
    {
        // --- 1. NORMALISASI INPUT (Agar selalu Array) ---
        if (!empty($bulan) && !is_array($bulan)) {
            $bulan = [$bulan];
        }
        if (!empty($tahun) && !is_array($tahun)) {
            $tahun = [$tahun];
        }

        // --- 2. PERSIAPAN FILTER DINAMIS (WHERE IN) ---
        $conditions = [];
        $params = [];

        // Filter Bulan
        if (!empty($bulan)) {
            $bulanPlaceholders = [];
            foreach ($bulan as $key => $val) {
                $placeholder = ":bulan_r_" . $key; // Nama parameter unik
                $bulanPlaceholders[] = $placeholder;
                $params[$placeholder] = $val;
            }
            $conditions[] = "MONTH(b.start_time) IN (" . implode(', ', $bulanPlaceholders) . ")";
        }

        // Filter Tahun
        if (!empty($tahun)) {
            $tahunPlaceholders = [];
            foreach ($tahun as $key => $val) {
                $placeholder = ":tahun_r_" . $key;
                $tahunPlaceholders[] = $placeholder;
                $params[$placeholder] = $val;
            }
            $conditions[] = "YEAR(b.start_time) IN (" . implode(', ', $tahunPlaceholders) . ")";
        }

        // String WHERE clause yang akan dipakai di Query B, C, dan D
        $whereClause = "";
        if (!empty($conditions)) {
            $whereClause = " AND " . implode(" AND ", $conditions);
        }


        // --- A. Statistik Umum (Tersedia/Tidak) ---
        // Note: Query ini biasanya snapshot real-time tabel rooms, 
        // jadi tidak dipengaruhi filter bulan/tahun (kecuali ada log status harian)
        $queryUmum = "SELECT 
                        COUNT(*) AS total_ruangan,
                        SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS tersedia,
                        SUM(CASE WHEN status != 'active' THEN 1 ELSE 0 END) AS tidak_tersedia
                    FROM rooms";
        $this->db->query($queryUmum);
        $resultUmum = $this->db->singleSet();


        // --- B. Ruangan Terpopuler ---
        // Menggunakan $whereClause
        $queryPopuler = "SELECT r.room_name, COUNT(b.id_booking) as jumlah
                        FROM bookings b
                        JOIN rooms r ON b.id_room = r.id_room
                        WHERE 1=1 $whereClause
                        GROUP BY b.id_room ORDER BY jumlah DESC LIMIT 1";
        
        $this->db->query($queryPopuler);
        foreach ($params as $key => $value) $this->db->bind($key, $value);
        $resultPopuler = $this->db->singleSet();


        // --- C. Rating Terbaik (Dari tabel Feedback) ---
        // Filter juga diterapkan disini agar rating sesuai periode yang dipilih
        $queryBest = "SELECT r.room_name, AVG(f.rating) as rata_rata
                    FROM feedback f
                    JOIN bookings b ON f.id_booking = b.id_booking
                    JOIN rooms r ON b.id_room = r.id_room
                    WHERE 1=1 $whereClause
                    GROUP BY r.id_room ORDER BY rata_rata DESC LIMIT 1";

        $this->db->query($queryBest);
        foreach ($params as $key => $value) $this->db->bind($key, $value);
        $resultBest = $this->db->singleSet();


        // --- D. Rating Terendah ---
        // Filter juga diterapkan disini
        $queryWorst = "SELECT r.room_name, AVG(f.rating) as rata_rata
                    FROM feedback f
                    JOIN bookings b ON f.id_booking = b.id_booking
                    JOIN rooms r ON b.id_room = r.id_room
                    WHERE 1=1 $whereClause
                    GROUP BY r.id_room ORDER BY rata_rata ASC LIMIT 1";

        $this->db->query($queryWorst);
        foreach ($params as $key => $value) $this->db->bind($key, $value);
        $resultWorst = $this->db->singleSet();


        // --- RETURN DATA ---
        return [
            'total_ruangan' => $resultUmum['total_ruangan'],
            'tersedia' => $resultUmum['tersedia'],
            'tidak_tersedia' => $resultUmum['tidak_tersedia'],
            
            'populer_nama' => $resultPopuler['room_name'] ?? '-',
            'populer_jumlah' => $resultPopuler['jumlah'] ?? 0,
            
            'rating_terbaik_nama' => $resultBest['room_name'] ?? '-',
            'rating_terbaik_nilai' => isset($resultBest['rata_rata']) ? number_format($resultBest['rata_rata'], 1) : '0.0',
            
            'rating_terendah_nama' => $resultWorst['room_name'] ?? '-',
            'rating_terendah_nilai' => isset($resultWorst['rata_rata']) ? number_format($resultWorst['rata_rata'], 1) : '0.0'
        ];
    }

    public function getAllBooking($bulan = [], $tahun = [])
    {
        // --- 1. NORMALISASI INPUT (Wajib Array) ---
        // Kita rapikan dulu di awal biar codingan bawahnya rapi
        if (!empty($bulan) && !is_array($bulan)) {
            $bulan = [$bulan];
        }
        if (!empty($tahun) && !is_array($tahun)) {
            $tahun = [$tahun];
        }

        // --- 2. BUILD STRING QUERY ---
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

        // Logic string SQL untuk Bulan
        if (!empty($bulan)) {
            $inBulan = [];
            foreach ($bulan as $i => $b) {
                $inBulan[] = ":bulan$i"; // Cuma bikin string ":bulan0", ":bulan1"
            }
            $sql .= " AND MONTH(b.start_time) IN (" . implode(',', $inBulan) . ")";
        }

        // Logic string SQL untuk Tahun
        if (!empty($tahun)) {
            $inTahun = [];
            foreach ($tahun as $i => $t) {
                $inTahun[] = ":tahun$i"; // Cuma bikin string ":tahun0", ":tahun1"
            }
            $sql .= " AND YEAR(b.start_time) IN (" . implode(',', $inTahun) . ")";
        }

        $sql .= " ORDER BY b.start_time DESC";

        // --- 3. PREPARE STATEMENT ---
        // Query harus di-prepare dulu sebelum di-bind
        $this->db->query($sql);


        // --- 4. BINDING VALUES (Sesuai request kamu) ---
        
        // Bind Bulan
        if (!empty($bulan)) {
            foreach ($bulan as $i => $b) {
                // Ini gaya binding request kamu
                $this->db->bind("bulan$i", $b); 
            }
        }

        // Bind Tahun
        if (!empty($tahun)) {
            foreach ($tahun as $i => $t) {
                // Ini gaya binding request kamu
                $this->db->bind("tahun$i", $t);
            }
        }

        // --- 5. EKSEKUSI & RETURN ---
        return $this->db->resultSet();
    }

    public function getAllUsers($jurusan = [], $roleName = [], $prodi = [])
    {

        if (!empty($jurusan) && !is_array($jurusan)) {
            $jurusan = [$jurusan];
        }

        if (!empty($prodi) && !is_array($prodi)) {
            $prodi = [$prodi];
        }

        if (!empty($roleName) && !is_array($roleName)) {
            $roleName = [$roleName];
        }

        $query = "SELECT u.id_user, u.username, r.role_name, u.jurusan_unit, u.prodi,u.nomor_induk , u.status
                  FROM users u
                  LEFT JOIN roles r ON u.id_role = r.id_role
                  WHERE r.id_role NOT IN (1,2)"; // Exclude Admin

        if (!empty($jurusan)) {
            $inJurusan = [];
            foreach ($jurusan as $i => $j) {
                $inJurusan[] = ":jurusan$i";
            }
            $query .= " AND u.jurusan_unit IN (" . implode(',', $inJurusan) . ")";
        }

        if (!empty($prodi)) {
            $inProdi = [];
            foreach ($prodi as $i => $p) {
                $inProdi[] = ":prodi$i";
            }
            $query .= " AND u.prodi IN (" . implode(',', $inProdi) . ")";
        }

        if (!empty($roleName)) {
            $inRole = [];
            foreach ($roleName as $i => $role) {
                $inRole[] = ":role$i";
            }
            $query .= " AND r.role_name IN (" . implode(',', $inRole) . ")";
        }

        $this->db->query($query);

        if (!empty($jurusan)) {
            foreach ($jurusan as $i => $j) {
                $this->db->bind("jurusan$i", $j); 
            }
        }

        if (!empty($prodi)) {
            foreach ($prodi as $i => $p) {
                $this->db->bind("prodi$i", $p); 
            }
        }

        if (!empty($roleName)) {
            foreach ($roleName as $i => $role) {
                $this->db->bind("role$i", $role); 
            }
        }
        
        return $this->db->resultSet();
    }
}