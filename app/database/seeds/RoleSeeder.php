<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class RoleSeeder extends AbstractSeed
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
        $table = $this->table('roles',['id' => 'id_role']);
        $users = $this->table('users', ['id' => 'id_user']);
        $users->truncate();
        $RolesData = [
            [
                'role_name' => 'superadmin', 
            ],
            [
                'role_name' => 'admin',
            ],
            [
                'role_name' => 'mahasiswa', 
            ],
            [
                'role_name' => 'dosen',
            ],
            [
                'role_name' => 'tenaga_pendidik',
            ]
            ];
            $table->insert($RolesData)->saveData();
    }
}
