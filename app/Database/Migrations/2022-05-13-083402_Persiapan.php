<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Persiapan extends Migration
{
    public function up()
    {
        /*
         * Users
         */
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'gauthid'            => ['type' => 'varchar', 'constraint' => 255],
            'email'            => ['type' => 'varchar', 'constraint' => 255],
            'fullname'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'user_image'       => ['type' => 'varchar', 'constraint' => 255, 'default' => 'default.svg'],
            'status_toko'      => ['type' => 'tinyint', 'constraint' => 2, 'null' => 0, 'default' => 0],
            'balance'			=> ['type' => 'bigint', 'constraint' => 255, 'null' => 0, 'default' => 0],
            'teleid'    => ['type' => 'varchar', 'constraint' => 14],
            'telecode'    => ['type' => 'varchar', 'constraint' => 32],
            'status'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');

        $this->forge->createTable('users', true);

        /*
         * role
         */
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'iduser'	 	=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'rules'	=> ['type' => 'varchar', 'constraint' => 255],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('iduser', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('role', true);


        /*
         * Apipayment
         */
        $this->forge->addField([
            'id'				 => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'apikey'			 => ['type' => 'varchar', 'constraint' => 255],
            'apiprivatekey'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'urlpaymentchannel'  => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'urlfeekalkulator'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'urlcreatepayment'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'urldetailtransaksi' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'kodemerchant'	     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'callback'		     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'         => ['type' => 'datetime', 'null' => true],
            'updated_at'         => ['type' => 'datetime', 'null' => true],
            'deleted_at'         => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('apipayment', true);

        /*
         * item
         */
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'status'	=> ['type' => 'int', 'constraint' => 11,  'null' => 0, 'default' => 0],
            'sub'		=> ['type' => 'int', 'constraint' => 11,  'null' => 0, 'default' => 0],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('item', true);

        /*
         * subitem
         */
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'item'		=> ['type' => 'int', 'constraint' => 11,  'unsigned' => true, 'default' => 0],
            'nama'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'status'	=> ['type' => 'int', 'constraint' => 11,  'null' => 0, 'default' => 0],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('item', 'item', 'id', false, 'CASCADE');
        $this->forge->createTable('sub_item', true);

        /*
         * toko
         */
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'userid'		=> ['type' => 'int', 'constraint' => 11,  'unsigned' => true, 'default' => 0],
            'username'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'logo'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'selogan'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'metode'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'nama_rek'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'no_rek'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'kartu'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'selfi'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'status'	=> ['type' => 'int', 'constraint' => 11,  'null' => 0, 'default' => 0],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addForeignKey('userid', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('toko', true);

        /*
         * transaksi_saldo
         */
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'owner'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'jenis'	 	=> ['type' => 'varchar', 'constraint' => 30],
            'order_number'	 	=> ['type' => 'varchar', 'constraint' => 30],
            'nominal'	 	=> ['type' => 'varchar', 'constraint' => 30],
            'fee'	 	=> ['type' => 'int', 'constraint' => 30],
            'metode'	 	=> ['type' => 'varchar', 'constraint' => 50],
            'status'	 	=> ['type' => 'varchar', 'constraint' => 20],
            'reference'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('owner', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('transaksi_saldo', true);

        /*
         * produk
         */
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'jenis'	 	=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'owner'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'gambar'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'nama'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'harga'	 	=> ['type' => 'int', 'constraint' => 11],
            'keterangan'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'slug'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'stok'	 	=> ['type' => 'int', 'constraint' => 11],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('jenis', 'sub_item', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('owner', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('produk', true);

        /*
         * keranjang
         */
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'buyer'	 	=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'produk'	=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'jumlah'	=> ['type' => 'int', 'constraint' => 11],
            'pesan'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'invoice'	=> ['type' => 'varchar', 'constraint' => 255],
            'status'	=> ['type' => 'int', 'constraint' => 11],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('buyer', 'users', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('produk', 'produk', 'id', false, 'CASCADE');
        $this->forge->createTable('keranjang', true);

        /*
         * invoice
         */
        $this->forge->addField([
            'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'channel'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'nominal'	 	=> ['type' => 'int', 'constraint' => 255],
            'fee'	 	=> ['type' => 'int', 'constraint' => 255],
            'referensi'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'status'	 	=> ['type' => 'varchar', 'constraint' => 255],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('invoice', true);
    }

    public function down()
    {
        // drop constraints first to prevent errors
        if ($this->db->DBDriver != 'SQLite3') {
            $this->forge->dropForeignKey('subitem', 'subitem_item_foreign');
            $this->forge->dropForeignKey('toko', 'toko_userid_foreign');
            $this->forge->dropForeignKey('transaksi_saldo', 'transaksi_saldo_owner_foreign');
            $this->forge->dropForeignKey('produk', 'produk_jenis_foreign');
            $this->forge->dropForeignKey('produk', 'produk_owner_foreign');
            $this->forge->dropForeignKey('keranjang', 'keranjang_buyer_foreign');
            $this->forge->dropForeignKey('keranjang', 'keranjang_produk_foreign');
            $this->forge->dropForeignKey('users', 'users_role_foreign');
        }

        $this->forge->dropTable('users', true);
        $this->forge->dropTable('apipayment', true);
        $this->forge->dropTable('produk', true);
        $this->forge->dropTable('item', true);
        $this->forge->dropTable('subitem', true);
        $this->forge->dropTable('toko', true);
        $this->forge->dropTable('transaksi_saldo', true);
        $this->forge->dropTable('keranjang', true);
        $this->forge->dropTable('invoice', true);
        $this->forge->dropTable('role', true);
    }
}
