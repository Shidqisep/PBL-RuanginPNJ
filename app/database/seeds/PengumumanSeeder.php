<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PengumumanSeeder extends AbstractSeed
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
        $table = $this->table('pengumuman',['id' => 'id_pengumuman'] );
        $pengumumanData = [
            [
                'nama_pengumuman' => 'tata tertib',
                'isi_pengumuman' =>
                    "1. dilarang menjual minuman keras\n" .
                    "2. dilarang makan dan minum\n" .
                    "3. dilarang kencing di ruangan\n"
            ]
            ];
            $table->insert($pengumumanData)->saveData();
    }
}
