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
        session()->setFlashdata('pesan', 'Toko berhasil ACC');
        return redirect()->to(base_url('admin/toko/pengajuan'));
    }

    public function pencairan_seller()
    {
        $pencairan = $this->transaksi_saldo;
        $pencairan->join('users', 'users.id = user', 'LEFT');
        $pencairan->join('toko', 'toko.userid = users.id', 'LEFT');
        $pencairan->select('transaksi_saldo.*');
        $pencairan->select('users.email');
        $pencairan->select('users.teleid');
        $pencairan->select('users.telecode');
        $pencairan->select('toko.metode');
        $pencairan->select('toko.nama_rek');
        $pencairan->select('toko.no_rek');
        $pencairan->where('transaksi_saldo.status', 1);
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Pencairan Seller | $this->namaweb",
            'pencairan' => $pencairan->paginate(10),
            'pager' => $pencairan->pager,
        ];
        return view('admin/pencairan_seller', $data);
    }

    public function pencairanacc($id = 0 )
    {
        $pencairan = $this->transaksi_saldo;
        $pencairan->join('users', 'users.id = user', 'LEFT');
        $pencairan->join('toko', 'toko.userid = users.id', 'LEFT');
        $pencairan->select('transaksi_saldo.*');
        $pencairan->select('users.email');
        $pencairan->select('users.teleid');
        $pencairan->select('users.telecode');
        $pencairan->select('toko.metode');
        $pencairan->select('toko.nama_rek');
        $pencairan->select('toko.no_rek');
        $pencairan->where('transaksi_saldo.id', $id);
        $pencairan->where('transaksi_saldo.status', 1);
        $pencairan = $pencairan->first();
        $info = $this->request->getVar('info');
        $nominal = $pencairan['nominal'];

        $getuser = $this->users->where('id', $pencairan['user'])->first();
        $this->transaksi_saldo->update(
            $id,
            [
                'status' => 2,
                'keterangan' => $info
            ]
        );
        if ($getuser['telecode'] == 'valid') {
            $chatId = $getuser['teleid'];
            $pesan = 'Mantap!, Pencairan saldo anda sudah dicairkan.\n'.number_to_currency($nominal, 'IDR', 'id_ID',0).' telah dikirimkan ke rekening anda. \n'.$info;
            kirimpesan($chatId, $pesan);
        }
        session()->setFlashdata('pesan', 'Pencairan berhasil di ACC');
        return redirect()->to(base_url('admin/pencairan/seller'));
    }

    public function pencairantolak($id = 0 )
    {
        $pencairan = $this->transaksi_saldo;
        $pencairan->join('users', 'users.id = user', 'LEFT');
        $pencairan->join('toko', 'toko.userid = users.id', 'LEFT');
        $pencairan->select('transaksi_saldo.*');
        $pencairan->select('users.email');
        $pencairan->select('users.teleid');
        $pencairan->select('users.telecode');
        $pencairan->select('toko.metode');
        $pencairan->select('toko.nama_rek');
        $pencairan->select('toko.no_rek');
        $pencairan->where('transaksi_saldo.id', $id);
        $pencairan->where('transaksi_saldo.status', 1);
        $pencairan = $pencairan->first();
        $info = $this->request->getVar('info');
        $tambahansaldo = $pencairan['fee'] + $pencairan['nominal'];

        $getuser = $this->users->where('id', $pencairan['user'])->first();
        $saldobaru = $getuser['balance'] + $tambahansaldo;
        $this->users->update(
            $pencairan['user'],
            [
                'balance' => $saldobaru
            ]
        );

        $this->transaksi_saldo->update(
            $id,
            [
                'status' => 3,
                'keterangan' => 'Dana dikembalikan, '.$info
            ]
        );
        if ($getuser['telecode'] == 'valid') {
            $chatId = $getuser['teleid'];
            $pesan = 'Ooops!, Pencairan saldo anda di tolak karena '.$info.'.\n'.number_to_currency($tambahansaldo, 'IDR', 'id_ID',0).' telah dikembalikan ke saldo anda. \nSaldo anda sekarang '.number_to_currency($saldobaru, 'IDR', 'id_ID',0);
            kirimpesan($chatId, $pesan);
        }
        session()->setFlashdata('pesan', 'Pencairan berhasil di Tolak');
        return redirect()->to(base_url('admin/pencairan/seller'));
    }

    public function listtoko()
    {
        $toko = $this->toko->findAll();
        $tokowp = [];
        foreach ($toko as $t){
            $produk = $this->produk->where('owner', $t['userid'])->findAll();
            $user = $this->users->where('id', $t['userid'])->first();
            $tokowp[] = [
                'toko' => $t,
                'user' => $user,
                'produk' => $produk,
            ];
        }
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "List Toko | $this->namaweb",
            'toko' => $tokowp,
        ];
        return view('admin/list_toko', $data);
    }

    public function banned($id=0)
    {
        $toko = $this->toko->where('id', $id)->first();
        if (!$toko){
            session()->setFlashdata('error', 'Toko tidak ditemukan');
            return redirect()->to(base_url('admin/toko/toko'));
        }
        $user = $this->users->where('id', $toko['userid'])->first();
        $this->users->update(
            $user['id'],
            [
                'status_toko' => 5
            ]
        );
        $this->toko->update(
            $id,
            [
                'status' => 0
            ]
        );
        if ($user['telecode'] == 'valid') {
            $chatId = $user['teleid'];
            $pesan = 'Ooops!, Toko anda di banned oleh admin. \nSilahkan hubungi CS untuk melepas banned';
            kirimpesan($chatId, $pesan);
        }
        session()->setFlashdata('pesan', 'Toko berhasil di banned');
        return redirect()->to(base_url('admin/toko/toko'));
    }

    public function unbanned($id=0)
    {
        $toko = $this->toko->where('id', $id)->first();
        if (!$toko){
            session()->setFlashdata('error', 'Toko tidak ditemukan');
            return redirect()->to(base_url('admin/toko/toko'));
        }
        $user = $this->users->where('id', $toko['userid'])->first();
        $this->users->update(
            $user['id'],
            [
                'status_toko' => 4
            ]
        );
        if ($user['telecode'] == 'valid') {
            $chatId = $user['teleid'];
            $pesan = 'Mantap!, Toko anda sudah di Unbanned oleh admin. \nSekarang anda bisa berjualan lagi di '. base_url();
            kirimpesan($chatId, $pesan);
        }
        session()->setFlashdata('pesan', 'Toko berhasil di lepas');
        return redirect()->to(base_url('admin/toko/toko'));
    }

    public function listproduk()
    {
        $produk = $this->produk;
        $produk->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $produk->join('sub_item', 'sub_item.id = produk.jenis', 'LEFT');
        $produk->join('item', 'item.id = sub_item.item', 'LEFT');
        $produk->select('produk.id');
        $produk->select('produk.nama');
        $produk->select('produk.harga');
        $produk->select('toko.username');
        $produk->select('sub_item.nama as nama_subitem');
        $produk->select('item.nama as nama_item');
        $produk = $produk->orderBy('produk.nama', 'ASC')->findAll();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "List Produk | $this->namaweb",
            'produk' => $produk,
        ];
        return view('admin/list_produk', $data);
    }

    public function hapusproduk($id = 0)
    {
        $produk = $this->produk->where('id', $id)->first();
        if (!$produk){
            session()->setFlashdata('error', 'Toko tidak ditemukan');
            return redirect()->to(base_url('admin/toko/produk'));
        }
        $user = $this->users->where('id', $produk['owner'])->first();
        if ($user['telecode'] == 'valid') {
            $chatId = $user['teleid'];
            $pesan = 'Ooops!, Produk "'. $produk['nama'] .'". Telah dihapus oleh admin karena melanggar aturan.';
            kirimpesan($chatId, $pesan);
        }
        $this->produk->delete($id);
        session()->setFlashdata('pesan', 'Produk Berhasil di hapus');
        return redirect()->to(base_url('admin/toko/produk'));
    }


}
