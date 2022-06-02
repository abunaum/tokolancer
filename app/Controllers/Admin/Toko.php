<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Toko extends BaseController
{
    public function __construct()
    {
        helper(['role','tele']);
        if (verifadmin() == 'invalid') {
            header("HTTP/1.1 403 Forbidden");
            header("Location: ". base_url());
            exit;
        }
    }

    public function pengajuan()
    {
        $user = new $this->users;
        $user->join('toko', 'toko.userid = users.id', 'LEFT');
        $user->where('status_toko', 2);
        $user->select('users.*');
        $user->select('toko.username as usernametoko');
        $user->select('toko.id as idtoko');
//        dd($user->findAll());
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin Toko | $this->namaweb",
            'user' => $user->paginate(10),
            'pager' => $user->pager,
        ];
        return view('admin/pengajuan_toko', $data);
    }

    public function pengajuandetail($id)
    {
        $toko = new $this->toko;
        $toko->join('users', 'users.id = toko.userid', 'LEFT');
        $toko->select('toko.*');
        $toko->select('users.telecode');
        $toko->select('users.teleid');
        $toko->select('users.email as email_user');
        $toko->where('status_toko', 2);
        $toko->where('toko.id', $id);

        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin Toko | $this->namaweb",
            'toko' => $toko->get()->getFirstRow()
        ];
        return view('admin/detail_pengajuan_toko', $data);
    }

    public function pengajuantolak($id)
    {
        $toko = new $this->toko;
        $toko = $toko->where('id', $id)->get()->getFirstRow();
        $user = new $this->users;
        $user = $user->where('id', $toko->userid)->get()->getFirstRow();
        if ($user->telecode == 'valid') {
            $chatId = $user->teleid;
            $pesan = $user->fullname . '\nMaaf aktivasi toko anda di tolak karena data yang dikirim tidak valid atau kurang jelas. Silahkan aktivasi ulang\n' . base_url('toko');
            kirimpesan($chatId, $pesan);
        }

        $usergass = new $this->users;
        $usergass->save([
            'id' => $user->id,
            'status_toko' => 3
        ]);
        @unlink(ROOTPATH . 'img/toko/aktivasi/' . $toko->kartu);
        @unlink(ROOTPATH . 'img/toko/aktivasi/' . $toko->selfi);
        $tokogass = new $this->toko;
        $tokogass->save([
            'id' => $toko->id,
            'nama_rek' => '',
            'no_rek' => '',
            'kartu' => '',
            'selfi' => '',

        ]);
        session()->setFlashdata('pesan', 'Toko berhasil ditolak');
        return redirect()->to(base_url('admin/toko/pengajuan'));
    }

    public function pengajuanacc($id)
    {
        $toko = new $this->toko;
        $toko = $toko->where('id', $id)->get()->getFirstRow();
        $user = new $this->users;
        $user = $user->where('id', $toko->userid)->get()->getFirstRow();

        if ($user->telecode == 'valid') {
            $chatId = $user->teleid;
            $pesan = $user->fullname . '\nMantap, Toko anda telah di aktivasi, sekarang anda bisa berjualan di ' . base_url();
            kirimpesan($chatId, $pesan);
            session()->setFlashdata('pesan', 'Toko berhasil ACC');
        }
        $usergass = new $this->users;
        $usergass->save([
            'id' => $user->id,
            'status_toko' => 4
        ]);
        $this->toko->save([
            'id' => $toko->id,
            'status' => 1
        ]);
        return redirect()->to(base_url('admin/toko/pengajuan'));
    }
    //--------------------------------------------------------------------

}
