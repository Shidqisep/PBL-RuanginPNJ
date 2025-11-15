<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableRoles extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $roles = $this->table('roles', ['id' => 'id_role']);
        $roles
            ->addColumn('role_name', 'string', ['limit' => 50])
            ->addTimestamps() // created_at & updated_at otomatis
            ->create();
    }
}
