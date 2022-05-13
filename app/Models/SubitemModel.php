<?php

namespace App\Models;

use CodeIgniter\Model;

class SubitemModel extends Model
{
    protected $table = 'sub_item';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';
    protected $allowedFields = ['nama', 'status', 'item'];
}
