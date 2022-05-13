<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiSaldoModel extends Model
{
    protected $table = 'transaksi_saldo';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['owner', 'jenis', 'order_number', 'nominal', 'fee', 'metode', 'status', 'reference'];
}
