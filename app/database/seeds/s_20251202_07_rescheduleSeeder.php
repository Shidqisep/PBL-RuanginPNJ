<?php

date_default_timezone_set('Asia/Jakarta');

class s_20251202_07_rescheduleSeeder extends Seeder{
    public function run()
    {
        // Variabel waktu dinamis untuk booking ID 5 (Geser ke besok)
        $resched_start_5 = date('Y-m-d H:i:s', strtotime('+1 day +1 hour'));
        $resched_end_5   = date('Y-m-d H:i:s', strtotime('+1 day +2 hours'));

        // Variabel waktu dinamis untuk booking ID 6 (Geser agak sore hari ini)
        $resched_start_6 = date('Y-m-d H:i:s', strtotime('+5 hours'));
        $resched_end_6   = date('Y-m-d H:i:s', strtotime('+7 hours'));

        $now = date('Y-m-d H:i:s');

        $sql = "INSERT INTO reschedule (id_reschedule,
            id_booking, cancel_reason, status_reschedule,
            cancel_by, new_start_time,
            new_end_time, created_at, updated_at
            ) VALUES
            (1, 5, NULL, 'pending', NULL, '$resched_start_5', '$resched_end_5', '$now', '$now'),
            (2, 7, NULL, 'pending', NULL, '2025-12-05 13:00:00', '2025-12-05 15:00:00', '$now', '$now')
            ";
        
        $this->db->query($sql);
        $this->db->execute();
    }
}