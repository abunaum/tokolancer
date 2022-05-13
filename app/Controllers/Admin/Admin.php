<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\TeleApiLibrary;

class Admin extends BaseController
{
    public $telelib;
    public function __construct()
    {
        $this->telelib = new TeleApiLibrary;
    }
    public function index()
    {
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin | $this->namaweb"
        ];
        return view('admin/index', $data);
    }

    public function item()
    {
        $item = $this->item;
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin Item | $this->namaweb",
            'item' => $item->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/item', $data);
    }

    public function item_tambah_prosess()
    {
        if (!$this->validate([
            'nama' => 'required'
        ])) {
            $validation = $this->validation;
            session()->setFlashdata('error', 'Item gagal di tambah , Coba lagi');
            return redirect()->to(base_url('admin/item'))->withInput();
        }
        $item = $this->item;
        $item->save([
            'nama' => $this->request->getVar('nama'),
            'status' => $this->request->getVar('status'),
            'sub' => $this->request->getVar('sub')
        ]);
        session()->setFlashdata('pesan', 'Item Berhasil di tambah');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_hapus($id)
    {
        $this->item->delete($id);
        session()->setFlashdata('pesan', 'Item Berhasil di hapus');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_nonaktifkan($id)
    {
        $item = $this->item;
        $item->save([
            'id' => $id,
            'status' => 0
        ]);
        session()->setFlashdata('pesan', 'Item Berhasil di ubah');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_aktifkan($id)
    {
        $item = $this->item;
        $item->save([
            'id' => $id,
            'status' => 1
        ]);
        session()->setFlashdata('pesan', 'Item Berhasil di ubah');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_subitem_nonaktifkan($id)
    {
        $item = $this->item;
        $item->save([
            'id' => $id,
            'sub' => 0
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di ubah');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_subitem_aktifkan($id)
    {
        $item = $this->item;
        $item->save([
            'id' => $id,
            'sub' => 1
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di ubah');
        return redirect()->to(base_url('admin/item'));
    }

    public function subitem()
    {
        $subitem = $this->subitem->orderBy('nama', 'asc');
        $item = $this->item->orderBy('nama', 'asc');
        $item = $item->where('status', 1);
        $item = $item->where('sub', 1);
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin SubItem | $this->namaweb",
            'itemlist' => $item->findAll(),
            'validation' => \Config\Services::validation(),
            'subitem' => $subitem->paginate(10),
            'pager' => $subitem->pager
        ];
        // dd($item);
        return view('admin/subitem', $data);
    }

    public function subitem_tambah_prosess()
    {
        if (!$this->validate([
            'nama' => 'required'
        ])) {
            $validation = $this->validation;
            session()->setFlashdata('error', 'Sub Item Gagal di ubah, Coba Lagi.');
            return redirect()->to(base_url('admin/subitem'))->withInput();
        }
        $subitem = $this->subitem;
        $subitem->save([
            'nama' => $this->request->getVar('nama'),
            'item' => $this->request->getVar('item'),
            'status' => $this->request->getVar('sub')
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di tambah');
        return redirect()->to(base_url('admin/subitem'));
    }

    public function subitem_nonaktifkan($id)
    {
        $subitem = $this->subitem;
        $subitem->save([
            'id' => $id,
            'status' => 0
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di ubah');
        return redirect()->to(base_url('admin/subitem'));
    }

    public function subitem_aktifkan($id)
    {
        $subitem = $this->subitem;
        $subitem->save([
            'id' => $id,
            'status' => 1
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di ubah');
        return redirect()->to(base_url('admin/subitem'));
    }

    public function subitem_hapus($id)
    {
        $produk = $this->produk->where('jenis', $id)->findAll();
        foreach ($produk as $p) {
            $idproduk = $p['id'];
            $gambarproduk = $p['gambar'];
            $prosesproduk = $this->produk;
            $prosesproduk->delete($idproduk);
            @unlink('img/produk/' . $gambarproduk);
        }
        $this->subitem->delete($id);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di hapus');
        return redirect()->to(base_url('admin/subitem'));
    }

    public function profile()
    {
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Password | $this->namaweb",
            'validation' => \Config\Services::validation()
        ];
        return view('admin/profile', $data);
    }

    public function ubahpassword()
    {
        if (!$this->validate([
            'passwordlama' => 'required',
            'passwordbaru' => 'required|strong_password',
            'ulangipassword' => 'required|matches[passwordbaru]'
        ])) {
            session()->setFlashdata('error', 'Password gagal di ubah , Coba lagi');
            return redirect()->to(base_url('admin/profile'))->withInput();
        }
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $userid = $user->id;
        $passworduser = $user->password_hash;
        $passwordlama = $this->request->getVar('passwordlama');
        $passwordbaru = $this->request->getVar('passwordbaru');

        $result = password_verify(base64_encode(
            hash('sha384', $passwordlama, true)
        ), $passworduser);
        if (!$result) {
            session()->setFlashdata('error', 'Password gagal di ubah , Password lama salah.');
            return redirect()->to(base_url('admin/profile'))->withInput();
        }
        $userproses = $this->users;
        $hashOptions = [
            "hashMemoryCost" => 2084,
            "hashTimeCost" => 4,
            "hashThreads" => 4,
            "hashCost" => 10
        ];
        $passwordhash = password_hash(
            base64_encode(
                hash('sha384', $passwordbaru, true)
            ),
            PASSWORD_DEFAULT,
            $hashOptions
        );
        $userproses->save([
            'id' => $userid,
            'password_hash' => $passwordhash
        ]);
        if ($user->telecode == 'valid') {
            $chatId = $user->teleid;
            $pesan = $user->username . '\nAnda berhasil mengubah password';
            $this->telelib->kirimpesan($chatId, $pesan);
        }
        session()->setFlashdata('pesan', 'Password berhasil di ubah');
        return redirect()->to(base_url('admin/profile'));
    }

    public function notifikasi()
    {
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Notifikasi | $this->namaweb",
            'validation' => \Config\Services::validation()
        ];
        if ($user->telecode == '') {
            return view('admin/notifikasi_belum', $data);
        } else if ($user->telecode != 'valid') {
            $data['tele'] = $user->teleid;
            return view('admin/notifikasi_pending', $data);
        } else {
            return view('admin/notifikasi_sudah', $data);
        }
    }

    public function tambahtele()
    {
        if (!$this->validate([
            'teleid' => 'required|is_natural_no_zero'
        ])) {
            session()->setFlashdata('error', 'Gagal menambah Telegram, Coba lagi.');
            return redirect()->to(base_url('admin/notifikasi'))->withInput();
        }

        $teleid = $this->request->getVar('teleid');
        $karakter = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($karakter), 0, 8);
        $chatId = $teleid;
        $pesan = 'Kode anda adalah : ' . $code;
        $hasiltele = $this->telelib->kirimpesan($chatId, $pesan);
        if ($hasiltele == 'sukses') {
            $this->users->save([
                'id' => user()->id,
                'teleid' => $chatId,
                'telecode' => $code
            ]);
            session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Telegram.');
            return redirect()->to(base_url('admin/notifikasi'));
        } else {
            session()->setFlashdata('error', 'Kode OTP gagal dikirim, pastikan sudah chat @TokoLancer_bot dan masukkan ID dengan benar');
            return redirect()->to(base_url('admin/notifikasi'));
        }
    }

    public function ubahtele()
    {
        if (!$this->validate([
            'teleid' => 'required|is_natural_no_zero'
        ])) {
            session()->setFlashdata('error', 'Gagal ubah Telegram, Coba lagi.');
            return redirect()->to(base_url('admin/notifikasi'))->withInput();
        }

        $teleid = $this->request->getVar('wa');
        $karakter = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($karakter), 0, 8);
        $chatId = $teleid;
        $pesan = 'Kode anda adalah : ' . $code;
        $hasiltele = $this->telelib->kirimpesan($chatId, $pesan);
        if ($hasiltele == 'sukses') {
            $this->users->save([
                'id' => user()->id,
                'teleid' => $teleid,
                'telecode' => $code
            ]);
            session()->setFlashdata('pesan', 'ID Telegram berhasil di ubah dan Kode berhasil di kirim.');
            return redirect()->to(base_url('admin/notifikasi'));
        } else {
            session()->setFlashdata('error', 'Kode OTP gagal dikirim, pastikan sudah chat @TokoLancer_bot dan masukkan ID dengan benar');
            return redirect()->to(base_url('admin/notifikasi'));
        }
    }

    public function telelagi()
    {
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $chatId = $user->teleid;
        $pesan = 'Kode anda adalah : ' . $user->telecode;
        $this->telelib->kirimpesan($chatId, $pesan);
        session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Telegram.');
        return redirect()->to(base_url('admin/notifikasi'));
    }

    public function veriftele()
    {
        $kode = strtoupper($this->request->getVar('kode'));
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $kodeuser = $user->telecode;
        if ($kode != $kodeuser) {
            session()->setFlashdata('error', 'Kode yang anda masukkan tidak sesuai.');
            return redirect()->to(base_url('admin/notifikasi'));
        } else {
            $this->users->save([
                'id' => user()->id,
                'telecode' => 'valid'
            ]);
            session()->setFlashdata('pesan', 'Notifikasi Telegram sudah aktif.');
            return redirect()->to(base_url('admin/notifikasi'));
        }
    }
    //--------------------------------------------------------------------

}
