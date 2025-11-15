<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableUsers extends AbstractMigration
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
        $table = $this->table('users', ['id' => 'id_user']);

        $table->addColumn('id_role', 'integer', ['signed' => false]) // Kolom untuk foreign key
              ->addForeignKey('id_role', 'roles', 'id_role', [
                  'delete' => 'RESTRICT', // Mencegah penghapusan role jika masih dipakai user
                  'update' => 'CASCADE'  // Update id_role di user jika di tabel roles berubah
              ])
              ->addColumn('username', 'string') 
              ->addColumn('password', 'string')
              ->addColumn('email', 'string')
              ->addColumn('nomor_induk', 'string', ['limit' => 30])
              ->addColumn('jurusanUnit', 'string', ['null' => true])
              ->addColumn('prodi', 'string', ['null' => true])
              ->addColumn('status', 'enum', [
                  'values' => ['pending', 'rejected', 'active', 'deleted', 'cancelled'],
                  'default' => 'pending'
              ])
              ->addColumn('suspend_count', 'integer', ['default' => 0])
              ->addColumn('email_verify', 'boolean', ['default' => false])
              ->addColumn('alasan_reject', 'string', ['null' => true])
              ->addColumn('foto_profil', 'string', ['null' => true])
              ->addColumn('foto_bukti', 'string', ['null' => true])
              
              // Menambahkan index unik
              ->addIndex('email', ['unique' => true])
              ->addIndex('nomor_induk', ['unique' => true])

              ->addTimestamps() 
              
              ->create();
    }
}
