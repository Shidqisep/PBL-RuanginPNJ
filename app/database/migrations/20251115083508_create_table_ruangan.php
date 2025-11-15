<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableRuangan extends AbstractMigration
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
        $table = $this->table('ruangan', ['id' => 'id_ruangan']);
        $table->addColumn('id_pengumuman', 'integer', ['signed' => false, 'null' => true])
                -> addForeignKey('id_pengumuman', 'pengumuman', 'id_pengumuman', [
                    'delete' => 'SET_NULL',
                    'update' => 'CASCADE'  
                ])
                ->addColumn('nama_ruangan', 'string')
                ->addColumn('img_ruangan', 'string', ['null' => true])
                ->addColumn('deskripsi', 'text', ['null' => true])
                ->addColumn('deskripsi_singkat', 'string',['limit' => 101] )
                ->addColumn('lantai', 'tinyinteger')
                ->addColumn('status', 'enum', [
                  'values' => ['active', 'non-active', 'deleted'],
                  'default' => 'active'
              ])
                ->addColumn('jumlah_maksimal', 'tinyinteger')
                ->addColumn('jumlah_minimal', 'tinyinteger')
                ->addTimestamps()
                ->create();
    }
}
