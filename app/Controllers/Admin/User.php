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

    public function disable($id = 0)
    {
        $user = $this->users->where('id',$id)->first();
        if (!$user){
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to(base_url('admin/user'));
        }
        $this->users->update(
            $id,
            [
                'status' => 0
            ]
        );
        session()->setFlashdata('pesan', 'User berhasil di banned');
        return redirect()->to(base_url('admin/user'));
    }

    public function enable($id = 0)
    {
        $user = $this->users->where('id',$id)->first();
        if (!$user){
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to(base_url('admin/user'));
        }
        $this->users->update(
            $id,
            [
                'status' => 1
            ]
        );
        session()->setFlashdata('pesan', 'User berhasil di lepas');
        return redirect()->to(base_url('admin/user'));
    }

}
