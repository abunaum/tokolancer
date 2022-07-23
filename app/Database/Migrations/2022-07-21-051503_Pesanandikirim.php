<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pesanandikirim extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'keranjang'	 	=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'nominal'	=> ['type' => 'int', 'constraint' => 11],
            'detail'	=> ['type' => 'varchar', 'constraint' => 255],
            'info'	=> ['type' => 'varchar', 'constraint' => 255],
            'status'	=> ['type' => 'int', 'constraint' => 11],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('keranjang', 'keranjang', 'id', false, 'CASCADE');
        $this->forge->createTable('pesanan_dikirim', true);
    }

    public function down()
    {
        // drop constraints first to prevent errors
        if ($this->db->DBDriver != 'SQLite3') {
            $this->forge->dropForeignKey('pesanan_dikirim', 'pesanan_dikirim_keranjang_foreign');
        }

        $this->forge->dropTable('pesanan_dikirim', true);
    }
}
