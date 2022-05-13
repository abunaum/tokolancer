<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'auth_groups_users';
    protected $useTimestamps = true;

    public function admin()
    {
        return $this->table('auth_groups_users')->where('group_id', 1);
    }
    public function carirole($id)
    {
        return $this->table('auth_groups_users')->where('user_id', $id);
    }
}
