<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class RuanganSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {

        $table = $this->table('ruangan', ['id' => 'id_ruangan']);
        $dataRuangan = [
            [
                'id_pengumuman'   => 1,  // atau NULL jika tidak memiliki pengumuman
                'nama_ruangan'    => 'Ruang Prancis',
                'img_ruangan'     => 'DefaultRuangan.jpg',
                'deskripsi'       => "Ruang Prancis untuk pertemuan penting.\n. Misalnya untuk belajar Grafika Komputer yang menyenangkan",
                'deskripsi_singkat' => "Ruang Prancis untuk orang prancis",
                'lantai'          => 1,
                'status'          => 'active',
                'jumlah_maksimal' => 8,
                'jumlah_minimal'  => 5,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id_pengumuman'   => null,
                'nama_ruangan'    => 'Ruangan Duta',
                'img_ruangan'     => 'DefaultRuangan.jpg',
                'deskripsi'       => "Ruangan besar khusus untuk para duta pnj yang terhormat. Kapasitas hingga 10 orang. Hidup Duta!",
                'deskripsi_singkat' => "Hidup Duta PNJ Hidup Duta PNJ Hidup Duta PNJ",
                'lantai'          => 2,
                'status'          => 'active',
                'jumlah_maksimal' => 6,
                'jumlah_minimal'  => 4,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id_pengumuman'   => null,
                'nama_ruangan'    => 'Ruangan Lentera Edukasi',
                'img_ruangan'     => 'DefaultRuangan.jpg',
                'deskripsi'       => "Ruang Lentera Edukasi adalah ruangan modern yang dirancang untuk mendukung kegiatan pembelajaran dan diskusi kelompok.",
                'deskripsi_singkat' => "Ruang bersih, tenang, dilengkapi wifi, cocok untuk belajar, rapat, dan aktivitas produktif.",
                'lantai'          => 1,
                'status'          => 'active',
                'jumlah_maksimal' => 10,
                'jumlah_minimal'  => 6,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]
        ];

        $table->insert($dataRuangan)->saveData();
    }
}
