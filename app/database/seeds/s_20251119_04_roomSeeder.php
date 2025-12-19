<?php

class s_20251119_04_roomSeeder extends Seeder {

    public function run()
    {
        $sql = "INSERT INTO rooms (id_room,
            id_announcement, room_name, img_room,
            description, short_description, floor,
            status, min_capacity, max_capacity,
            created_at, updated_at
            ) VALUES
            (1, 1, 'Ruang Asa', 'ruangAsa.jpg','Ruang konseling privat yang nyaman. Fasilitas meliputi 2 meja, 4 kursi, kipas angin, dan stopkontak untuk mendukung sesi diskusi yang fokus.','Ruang Bimbingan dan Konseling', 2, 'active', 2, 4, NOW(), NOW()),
            (2, 1, 'Lentera Edukasi', 'lenteraEdukasi.jpg','Ruang bimbingan kondusif dengan kapasitas fleksibel. Dilengkapi 2 meja, 4 kursi, kipas angin, kalender, dan stopkontak.','Ruang Bimbingan dan Konseling', 2, 'active', 2, 4, NOW(), NOW()),
            (3, 1, 'Galeri Literasi', 'galeriLiterasi.jpg','Area baca kelompok berkonsep lesehan santai. Tersedia 2 meja rendah, kipas angin, bantal duduk, dan akses listrik.','Ruang Baca Kelompok (Lesehan)', 2, 'active', 5, 12, NOW(), NOW()),
            (4, 1, 'Ruang Cendikia', 'ruangCendikia.jpg','Ruang diskusi lesehan yang nyaman. Fasilitas mencakup 2 meja rendah, kipas angin, bantal duduk, dan stopkontak untuk laptop.','Ruang Baca Kelompok (Lesehan)', 2, 'active', 5, 12, NOW(), NOW()),
            (5, 1, 'Pusat Prancis', 'pusatPrancis.jpg','Sudut khusus koleksi Bahasa Prancis dengan konsep lesehan dan terdapat sofa. Suasana tenang untuk mempelajari literatur dan budaya Prancis. Ada layar monitor besar lengkap dengan stopkontak.','Ruang Koleksi Bahasa Perancis (Lesehan)', 1, 'active', 6, 12, NOW(), NOW()),
            (6, 1, 'Sudut Pustaka', 'sudutPustaka.jpg','Pojok literasi yang luas dengan koleksi novel. Berkonsep lesehan dengan 4 meja dan akses listrik, cocok untuk membaca santai.','Ruang Baca Kelompok (Lesehan)', 2, 'active', 6, 12, NOW(), NOW()),
            (7, 1, 'Zona Interaktif', 'zonaInteraktif.jpg','Ruang kreasi untuk melepas penat. Tersedia 2 meja lesehan, bantal warna-warni, dan aneka permainan papan (catur, dkk).','Ruang Kreasi dan Rekreasi', 2, 'active', 6, 12, NOW(), NOW()),
            (8, 1, 'Ruang Sinergi', 'ruangSinergi.jpg','Ruang telekonferensi profesional. Dilengkapi set meja kursi dan proyektor/monitor untuk mendukung rapat daring atau presentasi.','Ruang Telekonferensi', 2, 'active', 6, 12, NOW(), NOW()),
            (9, 1, 'Ruang Layar', 'ruangLayar.jpg','Ruang audio visual lengkap dengan TV, sound system/DVD, kipas angin, 4 meja lesehan, dan bantal duduk untuk kenyamanan menonton.','Ruang Audio Visual', 2, 'active', 6, 12, NOW(), NOW()),
            (10, 1, 'Ruang Rapat', 'ruangRapat.jpg','Ruang rapat formal berkapasitas besar. Dirancang profesional untuk pertemuan resmi, sidang, atau diskusi strategis.','Ruang Rapat Besar', 2, 'spesial', 2, NULL, NOW(), NOW());
            ";
        $this->db->query($sql);
        $this->db->execute();
    }
}