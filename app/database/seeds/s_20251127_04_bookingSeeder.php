<?php

date_default_timezone_set('Asia/Jakarta');

class s_20251127_04_bookingSeeder extends Seeder{
    public function run()
    {

        $ongoing_start = date('Y-m-d H:i:s', strtotime('+1 hour')); 
        $ongoing_end   = date('Y-m-d H:i:s', strtotime('+2 hours'));

        $start_now = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $end_now = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $upcoming_start = date('Y-m-d H:i:s', strtotime('+3 hours'));
        $upcoming_end   = date('Y-m-d H:i:s', strtotime('+5 hours'));

        $upcoming_20min_start = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $ending_10min_end = date('Y-m-d H:i:s', strtotime('+20 minutes'));

        $now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO bookings (id_booking,
            id_room, id_user,
            total_person, institution_name,
            start_time, end_time,
            booking_code, status,
            reject_reason, cancel_by,
            created_at, updated_at
            ) VALUES
            -- === DATA AWAL (ID 1-27) === --
            (1, 1, 6, 3, NULL, '2025-12-01 10:00:00', '2025-12-01 13:00:00', 'UJ934TG', 'done', NULL, NULL, NOW(), NOW()),
            (2, 2, 7, 4, NULL, '2025-12-02 09:00:00', '2025-12-02 11:00:00', 'BK002', 'done', NULL, NULL, NOW(), NOW()),
            (3, 3, 8, 4, NULL, '2025-12-03 13:00:00', '2025-12-03 15:00:00', 'BK003', 'done', NULL, NULL, NOW(), NOW()),
            (4, 1, 6, 3, NULL, '2025-12-04 10:00:00', '2025-12-04 13:00:00', 'BK001', 'cancelled', NULL, NULL, NOW(), NOW()),
            (5, 3, 7, 5, NULL, '2025-12-20 09:00:00', '2025-12-20 11:00:00', 'BK-NEXT', 'pending', NULL, NULL, NOW(), NOW()),
            (6, 1, 8, 4, NULL, '2025-12-21 13:00:00', '2025-12-21 15:00:00', 'DUTAPNJ', 'pending', NULL, NULL, NOW(), NOW()),
            (7, 1, 6, 4, NULL, '2025-12-17 08:00:00', '2025-12-17 10:00:00', 'DNIWW987', 'pending', NULL, NULL, NOW(), NOW()),
            (8, 2, 6, 4, NULL, '2026-01-15 14:00:00', '2026-01-15 17:00:00', 'BK1002', 'done', NULL, NULL, NOW(), NOW()),
            (9, 3, 6, 5, NULL, '2026-01-29 09:00:00', '2026-01-29 11:00:00', 'BK1003', 'done', NULL, NULL, NOW(), NOW()),
            (10, 1, 6, 4, NULL, '2026-02-12 13:00:00', '2026-02-12 16:00:00', 'BK1004', 'cancelled', NULL, NULL, NOW(), NOW()),
            (11, 2, 6, 4, NULL, '2026-02-26 08:00:00', '2026-02-26 10:00:00', 'BK1005', 'done', NULL, NULL, NOW(), NOW()),
            (12, 3, 6, 8, NULL, '2026-03-12 11:00:00', '2026-03-12 13:00:00', 'BK1006', 'done', NULL, NULL, NOW(), NOW()),
            (13, 1, 6, 3, NULL, '2026-03-26 15:00:00', '2026-03-26 18:00:00', 'BK1007', 'done', NULL, NULL, NOW(), NOW()),
            (14, 2, 6, 3, NULL, '2026-04-09 10:00:00', '2026-04-09 12:00:00', 'BK1008', 'done', NULL, NULL, NOW(), NOW()),
            (15, 3, 6, 5, NULL, '2026-04-23 09:00:00', '2026-04-23 11:00:00', 'BK1009', 'done', NULL, NULL, NOW(), NOW()),
            (16, 2, 19, 4, NULL, '2025-11-15 10:00:00', '2025-11-15 12:00:00', 'RINA-099', 'cancelled', 'Ruangan sedang perbaikan AC', 'admin', '2025-11-10 10:00:00', '2025-11-14 10:00:00'),
            (17, 3, 20, 6, NULL, '2025-11-20 13:00:00', '2025-11-20 15:00:00', 'BAYU-CNCL', 'cancelled', NULL, 'user', '2025-11-18 09:00:00', '2025-11-19 09:00:00'),
            (18, 3, 22, 5, NULL, '2025-12-19 08:00:00', '2025-12-19 10:00:00', 'REQ-NEW02', 'pending', NULL, NULL, NOW(), NOW()),
            (19, 3, 23, 8, NULL, '2025-12-19 13:00:00', '2025-12-19 15:00:00', 'EKO-FIX', 'pending', NULL, NULL, NOW(), NOW()),
            (20, 2, 24, 4, NULL, '2025-12-16 10:00:00', '2025-12-16 12:00:00', 'NAQIB-01', 'done', NULL, NULL, '2025-12-14 10:00:00', NOW()),
            (21, 3, 25, 2, NULL, '2025-12-22 09:00:00', '2025-12-22 11:00:00', 'FANNY-X', 'cancelled', 'Jumlah peserta kurang dari kapasitas minimum ruangan', 'admin', NOW(), NOW()),
            (22, 3, 30, 5, NULL, '2025-12-24 13:00:00', '2025-12-24 15:00:00', 'HANA-X', 'cancelled', 'Kegiatan ditiadakan kampus', 'admin', NOW(), NOW()),
            (23, 1, 32, 2, NULL, '2025-12-10 15:00:00', '2025-12-10 17:00:00', 'IWAN-F', 'done', NULL, NULL, '2025-12-08 10:00:00', NOW()),
            (24, 2, 31, 2, NULL, '2025-12-28 08:00:00', '2025-12-28 10:00:00', 'MNT-R02', 'pending', NULL, NULL, NOW(), NOW()),
            (25, 1, 12, 3, NULL, '2025-12-14 13:00:00', '2025-12-14 15:00:00', 'STDG-1', 'done', NULL, NULL, NOW(), NOW()),
            (26, 1, 16, 3, NULL, '2025-12-05 09:00:00', '2025-12-05 11:00:00', 'STDG-2', 'done', NULL, NULL, NOW(), NOW()),
            (27, 2, 6, 3, NULL, '2025-12-18 10:00:00', '2025-12-18 12:00:00', 'LBJ-23', 'ongoing', 'Akun anda belum diverifikasi', 'admin', NOW(), NOW()),

            -- === DATA TAMBAHAN HISTORY (ID 28-47) OKTOBER & NOVEMBER === --
            
            -- Oktober History --
            (28, 1, 6, 5, 'Study Club AI', '2025-10-02 09:00:00', '2025-10-02 12:00:00', 'OCTH-1', 'done', NULL, NULL, '2025-10-01 08:00:00', NOW()),
            (29, 2, 7, 4, 'Rapat HIMA', '2025-10-05 13:00:00', '2025-10-05 15:00:00', 'OCTH-2', 'done', NULL, NULL, '2025-10-03 10:00:00', NOW()),
            (30, 3, 8, 3, 'Diskusi PKM', '2025-10-08 10:00:00', '2025-10-08 11:30:00', 'OCTH-3', 'done', NULL, NULL, '2025-10-05 09:00:00', NOW()),
            (31, 1, 12, 10, 'Briefing Lomba', '2025-10-12 15:00:00', '2025-10-12 17:00:00', 'OCTH-4', 'cancelled', 'Dosen pembimbing berhalangan', 'user', '2025-10-10 11:00:00', NOW()),
            (32, 2, 13, 6, 'Mentoring Junior', '2025-10-15 08:00:00', '2025-10-15 10:00:00', 'OCTH-5', 'done', NULL, NULL, '2025-10-12 14:00:00', NOW()),
            (33, 3, 15, 4, 'Persiapan UTS', '2025-10-18 13:00:00', '2025-10-18 16:00:00', 'OCTH-6', 'done', NULL, NULL, '2025-10-15 09:00:00', NOW()),
            (34, 1, 18, 5, 'Rapat Divisi', '2025-10-22 16:00:00', '2025-10-22 18:00:00', 'OCTH-7', 'done', NULL, NULL, '2025-10-20 10:00:00', NOW()),
            (35, 2, 27, 2, 'Bimbingan Skripsi', '2025-10-25 09:00:00', '2025-10-25 10:00:00', 'OCTH-8', 'done', NULL, NULL, '2025-10-23 08:00:00', NOW()),
            (36, 3, 6, 8, 'Bedah Buku', '2025-10-28 14:00:00', '2025-10-28 16:00:00', 'OCTH-9', 'cancelled', 'Listrik padam', 'admin', '2025-10-26 13:00:00', NOW()),
            (37, 1, 10, 3, 'Kelompok PPL', '2025-10-30 10:00:00', '2025-10-30 13:00:00', 'OCTH-10', 'done', NULL, NULL, '2025-10-28 09:00:00', NOW()),

            -- November History --
            (38, 2, 30, 5, 'Evaluasi Tendik', '2025-11-02 08:00:00', '2025-11-02 09:30:00', 'NOVH-1', 'done', NULL, NULL, '2025-11-01 07:00:00', NOW()),
            (39, 3, 32, 4, 'Cleaning Check', '2025-11-05 16:00:00', '2025-11-05 17:00:00', 'NOVH-2', 'done', NULL, NULL, '2025-11-05 10:00:00', NOW()),
            (40, 1, 6, 12, 'Workshop UI/UX', '2025-11-08 09:00:00', '2025-11-08 15:00:00', 'NOVH-3', 'done', NULL, NULL, '2025-11-01 10:00:00', NOW()),
            (41, 2, 9, 3, 'Interview Anggota', '2025-11-12 13:00:00', '2025-11-12 17:00:00', 'NOVH-4', 'done', NULL, NULL, '2025-11-10 11:00:00', NOW()),
            (42, 3, 14, 5, 'Review Jurnal', '2025-11-16 10:00:00', '2025-11-16 12:00:00', 'NOVH-5', 'done', NULL, NULL, '2025-11-14 09:00:00', NOW()),
            (43, 1, 21, 6, 'Latihan Presentasi', '2025-11-19 14:00:00', '2025-11-19 16:00:00', 'NOVH-6', 'cancelled', 'Ruangan dipakai mendadak oleh prodi', 'admin', '2025-11-15 10:00:00', NOW()),
            (44, 2, 28, 4, 'Rapat Dosen', '2025-11-23 09:00:00', '2025-11-23 11:00:00', 'NOVH-7', 'done', NULL, NULL, '2025-11-20 08:00:00', NOW()),
            (45, 3, 23, 7, 'Kunjungan Industri', '2025-11-25 08:00:00', '2025-11-25 12:00:00', 'NOVH-8', 'done', NULL, NULL, '2025-11-21 14:00:00', NOW()),
            (46, 1, 16, 3, 'Video Recording', '2025-11-28 13:00:00', '2025-11-28 15:00:00', 'NOVH-9', 'done', NULL, NULL, '2025-11-26 10:00:00', NOW()),
            (47, 2, 6, 5, 'Evaluasi Akhir Bulan', '2025-11-30 16:00:00', '2025-11-30 17:30:00', 'NOVH-10', 'done', NULL, NULL, '2025-11-29 09:00:00', NOW()),
            (48, 2, 6, 5, 'Evaluasi Akhir Bulan', '2025-12-18 12:27:00', '2025-12-18 14:30:00', 'NOVH-10', 'pending', NULL, NULL, '2025-11-29 09:00:00', NOW());
            ";

        $this->db->query($sql);
        $this->db->execute();
    }
}