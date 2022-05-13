<?php

namespace App\Models;

use CodeIgniter\Model;

class TokoModel extends Model
{
    protected $table = 'toko';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';
    protected $allowedFields = ['userid', 'username', 'nama', 'logo', 'selogan', 'metode', 'nama_rek', 'no_rek', 'kartu', 'selfi', 'status'];
}
