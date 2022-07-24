<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function __construct()
    {
        helper(['role']);
        if (verifadmin() == 'invalid') {
            header("HTTP/1.1 403 Forbidden");
            header("Location: ". base_url());
            exit;
        }
    }
    public function index()
    {
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin User | $this->namaweb",
            'user' => $this->users->where('id !=', user()->id)->paginate(10,'user'),
            'pager' => $this->users->where('id !=', user()->id)->pager,
        ];
        return view('admin/user', $data);
    }

    public function detail($id = 0)
    {
        $user = new $this->users;
        $user = $user->where('id', $id);
        $user = $user->get()->getFirstRow();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Detail User| $this->namaweb",
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        echo $user->fullname;
    }
    //--------------------------------------------------------------------

}
