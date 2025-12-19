<?php 

class RuanganModel {

    private $table = 'rooms';
    private $db;

    public function __construct(){
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

    // public function getRuanganForDashboard(){
    //     $this->db->query("SELECT id_room, room_name, img_room, short_description, floor, max_capacity, min_capacity, status 
    //                     FROM ". $this->table . " WHERE status = 'active'");
    //     $this->db->execute();
    //     return $this->db->resultSet();
    // }

    public function getRuanganForDashboard(){
        $this->db->query("SELECT * FROM v_ruangan_dashboard");
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getAllRuangan(){}

    public function getRuanganById($id_room){
        $this->db->query("SELECT * FROM  " .  $this->table . " WHERE id_room = :id_room");
        $this->db->bind(':id_room', $id_room);
        $this->db->execute();
        return $this->db->singleSet();
    }

    public function getAllRoomNames(){
        $this->db->query("SELECT room_name FROM rooms ");
        return $this->db->resultSet();
    }
    public function getLaporanRuangan()
    {
        // Query ini mengambil:
        // 1. Data detail ruangan
        // 2. Jumlah berapa kali dipinjam (COUNT)
        // 3. Rata-rata rating (AVG) dari tabel feedback
        
        $query = "SELECT 
                    r.id_room,
                    r.room_name,
                    r.status,
                    r.min_capacity,
                    r.max_capacity,
                    COUNT(b.id_booking) AS total_peminjaman,
                    IFNULL(AVG(f.rating), 0) AS average_rating
                  FROM rooms r
                  LEFT JOIN bookings b ON r.id_room = b.id_room
                  LEFT JOIN feedback f ON b.id_booking = f.id_booking
                  GROUP BY r.id_room
                  ORDER BY total_peminjaman DESC"; // Diurutkan dari yang paling sering dipinjam

        $this->db->query($query);
        return $this->db->resultSet(); // Mengembalikan banyak baris data
    }

    public function getRuanganWithRating($id_room){
        $query = "SELECT r.*, a.announcement_content,
                IFNULL(AVG(f.rating), 0) AS avg_rating,
                COUNT(f.id_feedback) AS total_review
                FROM rooms r
                LEFT JOIN announcement a ON r.id_announcement = a.id_announcement 
                LEFT JOIN bookings b ON r.id_room = b.id_room
                LEFT JOIN feedback f ON b.id_booking = f.id_booking
                WHERE r.id_room = :id_room
                GROUP BY r.id_room
        ";

        $this->db->query($query);
        $this->db->bind(':id_room', $id_room);
        $this->db->execute();
        return $this->db->singleSet();
    }

    public function getAllRuanganForAdmin($search = '', $status = '', $limit = 5, $start = 0){
        $query = "SELECT id_room, room_name, short_description, max_capacity, min_capacity, status FROM rooms";

        if ($search) {
        $query .= " WHERE room_name LIKE :keyword OR short_description LIKE :keyword";
        }

        if (!empty($status)) {
            if (!is_array($status)) $status = [$status];
            $in = [];
            foreach ($status as $i => $s) {
                $in[] = ":status$i";
            }
            $query .= " AND status IN (" . implode(',', $in) . ")";
        }

        $query .= " LIMIT :limit OFFSET :offset";
        $this->db->query($query);

        // Jika ada keyword, binding datanya
        if ($search) {
            $this->db->bind(':keyword', "%$search%");
        }

        if (!empty($status)) {
            foreach ($status as $i => $s) {
                $this->db->bind("status$i", $s);
            }
        }

        $this->db->bind(':limit', $limit);
        $this->db->bind(':offset', $start);
        return $this->db->resultSet();
    }

    public function getRuanganForAdmin($search = '', $status = '', $limit = 5, $start = 0){
        $query = "SELECT id_room, img_room, room_name, short_description, max_capacity, min_capacity, status FROM rooms WHERE status != :excluded_status";

        if ($search) {
        $query .= " AND (room_name LIKE :keyword OR short_description LIKE :keyword)";
        }

        if (!empty($status)) {
            if (!is_array($status)) $status = [$status];
            $in = [];
            foreach ($status as $i => $s) {
                $in[] = ":status$i";
            }
            $query .= " AND status IN (" . implode(',', $in) . ")";
        }

        $query .= " LIMIT :limit OFFSET :offset";
        $this->db->query($query);

        // Jika ada keyword, binding datanya
        if ($search) {
            $this->db->bind(':keyword', "%$search%");
        }

        if (!empty($status)) {
            foreach ($status as $i => $s) {
                $this->db->bind("status$i", $s);
            }
        }

        $this->db->bind(':limit', $limit);
        $this->db->bind(':offset', $start);
        $this->db->bind(':excluded_status', 'deleted');
        return $this->db->resultSet();
    }

    // === METHOD 2: HITUNG TOTAL (COUNT) ===
    public function countRuanganForAdmin($search = '', $status ='')
    {
        $query = "SELECT COUNT(*) as total FROM rooms WHERE status != :excluded_status";

        // Filter search harus SAMA PERSIS dengan method getRuanganForAdmin
        if ($search) {
            $query .= " AND (room_name LIKE :keyword OR short_description LIKE :keyword)";
        }

         if (!empty($status)) {
            if (!is_array($status)) $status = [$status];
            $in = [];
            foreach ($status as $i => $s) {
                $in[] = ":status$i";
            }
            $query .= " AND status IN (" . implode(',', $in) . ")";
        }

        $this->db->query($query);

        if ($search) {
            $this->db->bind(':keyword', "%$search%");
        }

        if (!empty($status)) {
            foreach ($status as $i => $s) {
                $this->db->bind("status$i", $s);
            }
        }

        $this->db->bind(':excluded_status', 'deleted');
        $result = $this->db->singleSet();
        return $result['total'] ?? $result->total ?? 0;
    }

    public function getRuangRapat(){
        $this->db->query("SELECT * FROM rooms WHERE status = 'spesial'");
        return $this->db->singleSet();
    }

    public function deleteRoom($id_room){
        $query = "UPDATE " . $this->table . " 
                SET status = :status 
                WHERE id_room = :id_room";

        $this->db->query($query);

        $this->db->bind('id_room', $id_room);
        $this->db->bind('status', 'deleted');

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function createRoom($data){
        $query = "INSERT INTO " . $this->table . " 
                    (room_name, img_room, description, short_description, floor, max_capacity, min_capacity, status, id_announcement)
                  VALUES
                    (:room_name, :img_room, :description, :short_description, :floor, :max, :min, :status, :id_announcement)";

        $this->db->query($query);
        
        // Binding data
        $this->db->bind('room_name', $data['room_name']);
        $this->db->bind('img_room', $data['img_room']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('short_description', $data['short_description']);
        $this->db->bind('floor', $data['floor']);
        $this->db->bind('max', $data['max_capacity']);
        $this->db->bind('min', $data['min_capacity']);
        $this->db->bind('status', $data['status']);
        
        // Default ID Announcement (Sesuai migrasi default 1, tapi kita bind eksplisit biar aman)
        $this->db->bind('id_announcement', 1); 
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateRoom($data){
        // Menggunakan UPDATE dan SET
        $query = "UPDATE rooms SET 
                    room_name = :room_name, 
                    img_room = :img_room, 
                    description = :description, 
                    short_description = :short_description, 
                    floor = :floor, 
                    max_capacity = :max, 
                    min_capacity = :min, 
                    status = :status,
                    id_announcement = :id_announcement
                WHERE id_room = :id_room";

        $this->db->query($query);

        // Binding data (sama seperti create, tapi tambah ID)
        $this->db->bind('id_room', $data['id_room']); // ID Ruangan wajib ada untuk update
        $this->db->bind('room_name', $data['room_name']);
        $this->db->bind('img_room', $data['img_room']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('short_description', $data['short_description']);
        $this->db->bind('floor', $data['floor']);
        $this->db->bind('max', $data['max_capacity']);
        $this->db->bind('min', $data['min_capacity']);
        $this->db->bind('status', $data['status']);
        
        // Default ID Announcement (Tetap 1 sesuai create function kamu)
        // Jika ingin dinamis, ganti angka 1 dengan $data['id_announcement']
        $this->db->bind('id_announcement', 1); 

        $this->db->execute();
        return $this->db->rowCount();
    }
}