<?php

class RescheduleModel {

    private $table = 'reschedule';
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

    public function getReschedulebyBookingId($id_booking){
        $this->db->query("SELECT * FROM reschedule WHERE id_booking = :id_booking");
        $this->db->bind('id_booking', $id_booking);
        return $this->db->resultSet();
    }

        public function getRescheduleById($id_reschedule){
        $this->db->query("SELECT * FROM reschedule WHERE id_reschedule = :id_booking");
        $this->db->bind('id_booking', $id_reschedule);
        return $this->db->resultSet();
    }

    public function getPendingReschedulebyBookingId($id_booking){
        $this->db->query("SELECT * FROM reschedule WHERE id_booking = :id_booking AND status = 'pending'");
        $this->db->bind('id_booking', $id_booking);
        return $this->db->resultSet();
    }

    public function getAllRescheduleByIdUser($id_user){
        $query = "SELECT DISTINCT rs.new_start_time, rs.new_end_time, r.room_name, rs.status_reschedule
            FROM reschedule rs
            JOIN bookings b ON rs.id_booking = b.id_booking
            JOIN rooms r ON b.id_room = r.id_room
            LEFT JOIN reschedule_members rm ON rm.id_reschedule = rs.id_reschedule
            WHERE b.id_user = :id_user OR rm.id_user = :id_user";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    public function getActiveRescheduleByBookingId($id_booking){
        //ini cari yang statusnya bukan rejected
        $query = "SELECT status_reschedule FROM reschedule 
                WHERE id_booking = :id_booking 
                AND status_reschedule != 'rejected'";
                
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        
        return $this->db->singleSet(); // Mengembalikan row jika ada, false jika tidak ada
    }

    public function checkUserHasReschedule($id_user){
        $query = "SELECT 1 
                FROM reschedule rs
                LEFT JOIN reschedule_members rm ON rm.id_reschedule = rs.id_reschedule 
                WHERE rs.status_reschedule = 'pending'
                AND rm.id_user = :id_user
                LIMIT 1";
        
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);

        return $this->db->singleSet() ? true : false;
    }

    //ini dia update ke decline di reschedule
    public function declinePendingByUser($id_user) {
        // Dengan join ke 'reschedule_members' (rm) untuk pengecekan member
        $query = "UPDATE reschedule rs
                LEFT JOIN reschedule_members rm 
                ON rm.id_reschedule = rs.id_reschedule 
                SET rs.status_reschedule = 'declined'
                WHERE rm.id_user = :id_user 
                AND rs.status_reschedule = 'pending'";

        $this->db->query($query);
        $this->db->bind('id_user', $id_user);

        // Eksekusi query
        $this->db->execute();
        
        // Mengembalikan jumlah baris yang berubah (0 jika tidak ada yang pending, 1 jika ada)
        return $this->db->rowCount(); 
    }



    //ini ambil data buat detail reschedule
    // untuk rating ini kita harus join berdasarkan ruangan ya tidak bisa per booking
    public function getRescheduleDetail($id_res) {
        $query = "SELECT rs.id_booking, rs.id_reschedule, rs.new_start_time, rs.new_end_time, rs.status_reschedule,
                r.room_name, r.min_capacity, r.max_capacity, r.floor, r.description, b.booking_code,
                IFNULL(AVG(f.rating), 0) AS avg_rating,
                COUNT(f.id_feedback) AS total_review,
                u.username, u.email, u.jurusan_unit, u.nomor_induk 
                FROM reschedule rs 
                JOIN bookings b ON rs.id_booking = b.id_booking
                JOIN rooms r ON b.id_room = r.id_room 
                JOIN users u ON b.id_user = u.id_user
                LEFT JOIN bookings b2 ON r.id_room = b2.id_room
                LEFT JOIN feedback f ON b2.id_booking = f.id_booking
                WHERE rs.id_reschedule = :id_res
                GROUP BY r.id_room";

        $this->db->query($query);
        $this->db->bind('id_res', $id_res);
        return $this->db->singleSet();
    }

    public function filterReschedules($limit, $start, $search = '', $status = [])
    {
        // Sesuaikan kolom dan join tabel reschedule kamu
        $sql = "SELECT res.id_reschedule, res.new_start_time AS start_time, res.new_end_time AS end_time,
                res.status_reschedule as status, b.booking_code, u.username, r.room_name
                FROM reschedule res
                JOIN bookings b ON res.id_booking = b.id_booking
                JOIN rooms r ON b.id_room = r.id_room
                JOIN users u ON b.id_user = u.id_user
                WHERE 1=1";

       if (!empty($status)) {
            if (!is_array($status)) $status = [$status];
            $in = [];
            foreach ($status as $i => $s) {
                $in[] = ":status$i";
            }
            $sql .= " AND res.status_reschedule IN (" . implode(',', $in) . ")";
        }

        if (!empty($search)) {
            $sql .= " AND (u.username LIKE :search OR res.reason LIKE :search)";
        }

        $sql .= " ORDER BY res.created_at DESC LIMIT :limit OFFSET :start";

        $this->db->query($sql);

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

    public function countFilterReschedules($search = '', $status = [])
    {
        // Sesuaikan kolom dan join tabel reschedule kamu
        $sql = "SELECT COUNT(*) as total
                FROM reschedule res
                JOIN bookings b ON res.id_booking = b.id_booking
                JOIN rooms r ON b.id_room = r.id_room
                JOIN users u ON b.id_user = u.id_user
                WHERE 1=1";

       if (!empty($status)) {
            if (!is_array($status)) $status = [$status];
            $in = [];
            foreach ($status as $i => $s) {
                $in[] = ":status$i";
            }
            $sql .= " AND res.status_reschedule IN (" . implode(',', $in) . ")";
        }

        if (!empty($search)) {
            $sql .= " AND (u.username LIKE :search OR res.reason LIKE :search)";
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
        
        return $this->db->singleSet()['total'];
    }


    //ini pending yang paling atas
    public function getAllRescheduleRequests(){
        $query = "SELECT 
                r.id_reschedule, r.new_start_time AS start_time, r.new_end_time AS end_time,
                r.status_reschedule as status, r.id_reschedule,
                rm.room_name,
                b.booking_code, u.username
              FROM reschedule r
              JOIN bookings b ON r.id_booking = b.id_booking
              JOIN rooms rm ON b.id_room = rm.id_room
              JOIN users u ON b.id_user = u.id_user
              ORDER BY 
                CASE WHEN r.status_reschedule = 'pending' THEN 0 ELSE 1 END,
                r.created_at DESC";
                
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getRescheduleMembers($id_res){
        $this->db->query("SELECT u.username, u.id_user FROM reschedule_members rm 
                        JOIN users u ON rm.id_user = u.id_user
                        WHERE rm.id_reschedule = :id_res");
        $this->db->bind('id_res', $id_res);
        return $this->db->resultSet();
    }

    //ini menghitung ada berapa members reschedule untuk rescheduelan itu
    public function countRescheduleMembers($id_reschedule) {
        $query = "SELECT count(*) as total FROM reschedule_members WHERE id_reschedule = :id";
        $this->db->query($query);
        $this->db->bind('id', $id_reschedule);
        return $this->db->singleSet()['total'];
    }

    //ini cancel reschedule saat booking utamanya di cancel
    public function cancelRescheduleByUser($id_booking){
        $query = "UPDATE reschedule 
              SET status_reschedule = 'declined', 
                  cancel_reason = 'Booking utama dibatalkan oleh user',
                  cancel_by = 'system'
              WHERE id_booking = :id_booking 
              AND status_reschedule = 'pending'";
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cancelPendingReschedulesByRoom($id_room){
        // Kita perlu join ke tabel bookings (b) untuk tahu reschedule ini milik ruangan mana
        $query = "UPDATE reschedule r
                JOIN bookings b ON r.id_booking = b.id_booking
                SET r.status_reschedule = 'cancelled',
                    r.cancel_reason = 'ruangan dihapus admin',
                    r.cancel_by = 'system'
                WHERE b.id_room = :id_room 
                AND r.status_reschedule = 'pending'";

        $this->db->query($query);
        $this->db->bind('id_room', $id_room);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cancelRelatedReschedule($id_booking)
    {
        $query = "UPDATE reschedule SET status_reschedule = 'cancelled', cancel_by = 'system', cancel_reason = 'Booking utama dibatalkan' 
                  WHERE id_booking = :id_booking AND status_reschedule = 'pending'";
        $this->db->query($query);
        $this->db->bind('id_booking', $id_booking);
        $this->db->execute();
    }

    public function updateStatus($id_reschedule, $status, $reason = NULL) {
        $query = "UPDATE reschedule 
                    SET status_reschedule = :status,
                    cancel_reason = :reason
                    WHERE id_reschedule = :id";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('reason', $reason);
        $this->db->bind('id', $id_reschedule);
        $this->db->execute();
        return $this->db->rowCount();
    }


// Create Data Reschedule Header
    public function createReschedule($data){
        $query = "INSERT INTO reschedule 
                (id_booking, status_reschedule, new_start_time, new_end_time, created_at)
                VALUES 
                (:id_booking, :status, :start, :end, CURRENT_TIMESTAMP)";
    
        $this->db->query($query);
        $this->db->bind('id_booking', $data['id_booking']);
        $this->db->bind('status', $data['status_reschedule']);
        $this->db->bind('start', $data['new_start_time']);
        $this->db->bind('end', $data['new_end_time']);
    
        $this->db->execute();
        return $this->db->lastInsertId();
    }

// Create Data Member Reschedule
    public function insertRescheduleMember($id_reschedule, $id_user){
        $query = "INSERT INTO reschedule_members (id_reschedule, id_user) VALUES (:id_res, :id_user)";
    
        $this->db->query($query);
        $this->db->bind('id_res', $id_reschedule);
        $this->db->bind('id_user', $id_user);
        $this->db->execute();
    }
    
    public function getRescheduleJoinBooking($id_reschedule) {
        $query = "SELECT r.*, b.id_room, b.booking_code, 
                        b.start_time as old_start, 
                        b.end_time as old_end
                FROM reschedule r
                JOIN bookings b ON r.id_booking = b.id_booking
                WHERE r.id_reschedule = :id";
                
        $this->db->query($query);
        $this->db->bind('id', $id_reschedule);
        return $this->db->singleSet();
    }

    //ini dipake di controller booking, jadi dia akan update status reschedule ke decline
    public function autoCancelRescheduleConflict($id_room, $start_time, $end_time){
        $query = "UPDATE reschedule r
            JOIN bookings b ON r.id_booking = b.id_booking
            SET r.status_reschedule = 'declined', r.cancel_reason = 'Sistem: Waktu ini telah diambil oleh booking baru.'
            WHERE r.status_reschedule = 'pending'
            AND b.id_room = :id_room
            AND r.new_start_time < :end_time 
            AND r.new_end_time > :start_time;";

        $this->db->query($query);
        $this->db->bind('id_room', $id_room);
        $this->db->bind('start_time', $start_time);
        $this->db->bind('end_time', $end_time);
        $this->db->execute();
        return $this->db->rowCount();
    }

}