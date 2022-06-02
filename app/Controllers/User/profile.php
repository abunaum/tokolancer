<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\Itemlibrary;
use App\Libraries\TeleApiLibrary;

class profile extends BaseController
{
    public $telelib;

    public function __construct()
    {
        $this->telelib = new TeleApiLibrary;
        $this->getitem = new Itemlibrary();
    }

    public function index()
    {
        $item = $this->getitem->getsub();
        $data = [
            'khusus' => 'profile',
            'judul' => "Profile | $this->namaweb",
            'item' => $item,
            'validation' => \Config\Services::validation(),
        ];

        return view('halaman/user/profile', $data);
    }

    public function ubahdata()
    {
        $file = $this->request->getFiles();
        $nama = $this->request->getVar('nama');
        $gambar = $file['gambar'];
        if (!$this->validate([
            'nama' => 'required|alpha_space|min_length[3]',
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar',
                ],
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal mengubah data , Coba lagi');

            return redirect()->to(base_url('user/profile'))->withInput();
        }
        if ($gambar->getError() == 4) {
            $this->users->save([
                'id' => user()->id,
                'fullname' => $nama,
            ]);
        } else {
            $user = $this->users->where('id', user()->id)->get()->getFirstRow();
            if ($user->user_image != 'default.svg') {
                @unlink('img/profile/' . $user->user_image);
            }
            $namagambar = $gambar->getRandomName();
            $gambar->move('img/profile', $namagambar);
            $this->users->save([
                'id' => user()->id,
                'fullname' => $nama,
                'user_image' => $namagambar,
            ]);
        }
        session()->setFlashdata('pesan', 'Mantap , data berhasil di ubah');
        return redirect()->to(base_url('user/profile'));
    }

    public function ubahpassword()
    {
        if (!$this->validate([
            'passwordlama' => 'required',
            'passwordbaru' => 'required|strong_password',
            'ulangipassword' => 'required|matches[passwordbaru]',
        ])) {
            session()->setFlashdata('error', 'Password gagal di ubah , Coba lagi');

            return redirect()->to(base_url('user/profile'))->withInput();
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

            return redirect()->to(base_url('user/profile'))->withInput();
        }
        $userproses = $this->users;
        $hashOptions = [
            'hashMemoryCost' => 2084,
            'hashTimeCost' => 4,
            'hashThreads' => 4,
            'hashCost' => 10,
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
            'password_hash' => $passwordhash,
        ]);
        if ($user->telecode == 'valid') {
            $chatId = $user->teleid;
            $pesan = $user->username . '\nAnda berhasil mengubah password';
            $this->telelib->kirimpesan($chatId, $pesan);
        }
        session()->setFlashdata('pesan', 'Password berhasil di ubah');
        return redirect()->to(base_url('user/profile'));
    }

    //--------------------------------------------------------------------
}
