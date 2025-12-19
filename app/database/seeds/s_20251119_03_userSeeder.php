<?php

class s_20251119_03_userSeeder extends Seeder{

    public function run()
    {
        $passwordUser = password_hash('user123', PASSWORD_DEFAULT);
        $passwordAdmin = password_hash('admin123', PASSWORD_DEFAULT);
        $expired = date('Y-m-d H:i:s', strtotime("-1 years"));
        $expired4Years = date('Y-m-d H:i:s', strtotime("+4 years"));
        $expired3Years = date('Y-m-d H:i:s', strtotime("+3 years"));

        $sql = "INSERT IGNORE INTO users ( id_user,
            id_role, username, password, email,
            nomor_induk, jurusan_unit, prodi,
            status, suspend_count, email_verified,
            reject_reason, profile_photo, kubaca_photo,
            expired_at, created_at, updated_at
            ) VALUES
            (1, 1, 'superadmin', '$passwordAdmin', 'superadmin@example.com', '0001', 'Admin', NULL, 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (2, 2, 'admin', '$passwordAdmin', 'admin@example.com', '19877654', 'Admin', NULL, 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (3, 3, 'Anton Subanton', '$passwordUser', 'anton@example.com', '22110033', 'TIK', 'Teknik Informatika dan Komputer', 'active', 2, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (4, 4, 'dosen', '$passwordUser', 'dosen@example.com', '55667788', 'Administrasi', 'Sekretariat', 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (5, 5, 'staff', '$passwordUser', 'staff@example.com', '55667789', 'Staff', 'Sekretariat', 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (6, 3, 'Shidqi Athallah Bahri', '$passwordUser', 'shidqi.athallah.bahri.tik24@stu.pnj.ac.id', '2407411038', 'Teknik Informatika dan Komputer', 'D4 Teknik Informatika', 'active', 0, 1, NULL, NULL, NULL, NULL , NOW(), NOW()),
            (7, 4, 'Nadiva Mecca Rimanda', '$passwordUser', 'nadiva.mecca.rimanda.tik24@stu.pnj.ac.id', '2407411037', 'Teknik Informatika', NULL, 'pending', 0, 1, NULL, NULL, NULL, NULL , NOW(), NOW()),
            (8, 5, 'Naqib Zuhair Al-Hudri', '$passwordUser', 'naqib.zuhair.tik24@stu.pnj.ac.id', '2407411039', 'Perpustakaan', NULL, 'active', 0, 1, NULL, NULL, NULL, NULL , NOW(), NOW()),
            (9, 3, 'antin', '$passwordUser', 'expired@example.com', '556677891', 'Teknik Informatika dan Komputer', 'Teknik Multimedia', 'active', 0, 1, NULL, NULL, NULL, '$expired' , NOW(), NOW()),
            (10, 3, 'Lebron James', '$passwordUser', 'lebron.tik24@stu.pnj.ac.id', '2407411045', 'Teknik Informatika dan Komputer', 'D4 Teknik Yapping', 'pending', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (11, 4, 'Naufal Bryant', '$passwordUser', 'naufal.tik24@stu.pnj.ac.id', '2407411046', 'Teknik At-Taufiq', NULL, 'pending', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (12, 3, 'Sulthon Fabian', '$passwordUser', 'sulthon.tik24@stu.pnj.ac.id', '2407411047', 'Teknik Informatika dan Komputer', 'D4 Teknik Informatika', 'active', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (13, 3, 'Fadhil Ramadhan', '$passwordUser', 'fadhil.tik24@stu.pnj.ac.id', '2407411048', 'Teknik Elektro', 'D3 Listrik Kantor', 'active', 0, 1, NULL, NULL, NULL, '$expired3Years', NOW(), NOW()),
            (14, 4, 'Sabrina Aulia', '$passwordUser', 'sabrina.sekret@pnj.ac.id', '2407411049', 'Administrasi', 'Sekretariat', 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (15, 5, 'Dimas Pranata', '$passwordUser', 'dimas.staff@pnj.ac.id', '2407411050', 'Staff', 'Perpustakaan', 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (16, 3, 'Farhan Mecca', '$passwordUser', 'farhan.mecca.tik24@stu.pnj.ac.id', '2407411051', 'Teknik Informatika dan Komputer', 'D4 Teknik Multimedia Jaringan', 'active', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (17, 3, 'Antonio Gonzalez', '$passwordUser', 'antonio.tm24@stu.pnj.ac.id', '2407411052', 'Teknik Mesin', 'D4 Alat Berat', 'pending', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            
            (18, 3, 'Rina Agustina', '$passwordUser', 'rina.tik24@stu.pnj.ac.id', '1111111111', 'Teknik Informatika dan Komputer', 'D4 Teknik Informatika', 'active', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (19, 3, 'Bayu Pamungkas', '$passwordUser', 'bayu.tmj24@stu.pnj.ac.id', '2222222222', 'Teknik Informatika dan Komputer', 'D4 Teknik Multimedia Jaringan', 'active', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (20, 3, 'Citra Kirana', '$passwordUser', 'citra.ak24@stu.pnj.ac.id', '3333333333', 'Akuntansi', 'D4 Akuntansi Keuangan', 'pending', 0, 1, NULL, NULL, NULL, '$expired3Years', NOW(), NOW()),
            (21, 3, 'Dewi Sartika', '$passwordUser', 'dewi.tik24@stu.pnj.ac.id', '4444444444', 'Teknik Informatika dan Komputer', 'D4 Teknik Informatika', 'active', 1, 1, NULL, NULL, NULL, '$expired3Years', NOW(), NOW()),
            (22, 3, 'Eko Prasetyo', '$passwordUser', 'eko.mesin24@stu.pnj.ac.id', '5555555555', 'Teknik Mesin', 'D3 Teknik Mesin', 'active', 0, 1, NULL, NULL, NULL, '$expired3Years', NOW(), NOW()),
            (23, 3, 'Fanny Amalia', '$passwordUser', 'fanny.tik24@stu.pnj.ac.id', '6666666666', 'Teknik Informatika dan Komputer', 'D1 Teknik Komputer Jaringan', 'active', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (24, 3, 'Gilang Ramadhan', '$passwordUser', 'gilang.elektro24@stu.pnj.ac.id', '7777777777', 'Teknik Elektro', 'D4 Teknik Otomasi Listrik', 'active', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (25, 3, 'Hana Pertiwi', '$passwordUser', 'hana.tik24@stu.pnj.ac.id', '8888888888', 'Teknik Informatika dan Komputer', 'D4 Teknik Informatika', 'pending', 0, 1, NULL, NULL, NULL, '$expired4Years', NOW(), NOW()),
            (26, 3, 'Iwan Fals', '$passwordUser', 'iwan.an24@stu.pnj.ac.id', '9999999999', 'Administrasi Niaga', 'D4 MICE', 'active', 0, 1, NULL, NULL, NULL, '$expired', NOW(), NOW()),

            -- 3 DOSEN (Role 4) --
            (27, 4, 'Dr. Budi Santoso, M.Kom', '$passwordUser', 'budi.dosen@pnj.ac.id', '111111111111111111', 'Teknik Informatika dan Komputer', NULL, 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (28, 4, 'Siti Maesaroh, M.T', '$passwordUser', 'siti.dosen@pnj.ac.id', '222222222222222222', 'Teknik Elektro', NULL, 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (29, 4, 'Ir. Joko Susilo', '$passwordUser', 'joko.dosen@pnj.ac.id', '333333333333333333', 'Teknik Mesin', NULL, 'pending', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),

            -- 3 TENDIK (Role 5) --
            (30, 5, 'Kurniawan Staff', '$passwordUser', 'kurniawan.staff@pnj.ac.id', '44444444', 'Keuangan', 'Staff Keuangan', 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (31, 5, 'Larasati Admin', '$passwordUser', 'larasati.staff@pnj.ac.id', '55555555', 'Akademik', 'Pelayanan Akademik', 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
            (32, 5, 'Maman Suparman', '$passwordUser', 'maman.staff@pnj.ac.id', '66666666', 'Umum', 'Fasilitas & Sarpras', 'active', 0, 1, NULL, NULL, NULL, NULL, NOW(), NOW())"
            ;

    $this->db->query($sql);
    $this->db->execute();
    }

}