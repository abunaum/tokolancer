<?php

namespace App\Models;

use CodeIgniter\Model;

class Keranjang extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'keranjang';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ['buyer', 'produk', 'jumlah', 'pesan', 'invoice', 'status'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';
}
