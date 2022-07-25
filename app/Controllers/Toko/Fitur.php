<?php

namespace App\Controllers\Toko;

use App\Controllers\BaseController;
use App\Libraries\Itemlibrary;

class Fitur extends BaseController
{
    public function __construct()
    {
        helper(['role','tele']);
        $this->getitem = new Itemlibrary;
    }

    public function index()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $data = [
            'judul' => "Toko | $this->namaweb",
            'item' => $item,
            'toko' => $toko->where('userid', user()->id)->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/toko', $data);
    }

    public function buat_toko()
    {
        if (!$this->validate([
            'username' => 'required|alpha_numeric_space|min_length[3]|is_unique[toko.username]',
            'selogan' => 'required',
            'metode' => 'required',
            'logo' => [
                'rules' => 'uploaded[logo]|max_size[logo,1024]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar toko masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar'
                ]
            ]
        ])) {
            session()->setFlashdata('error', 'Gagal membuat toko , Coba lagi');
            return redirect()->to(base_url('toko'))->withInput();
        }
        $logo = $this->request->getFile('logo');
        // pindah lokasi logo
        $namalogo = $logo->getRandomName();
        $logo->move('img/toko', $namalogo);
        $this->toko->save([
            'userid' => user()->id,
            'username' => url_title($this->request->getVar('username'), '_'),
            'logo' => $namalogo,
            'selogan' => $this->request->getVar('selogan'),
            'metode' => $this->request->getVar('metode')
        ]);

        $this->users->save([
            'id' => user()->id,
            'status_toko' => 1
        ]);

        session()->setFlashdata('pesan', 'Toko berhasil di buat');
        return redirect()->to(base_url('toko'));
    }

    public function aktivasi()
    {
        if (!$this->validate([
            'nama' => 'required|alpha_space|min_length[3]',
            'rekening' => 'required|numeric|min_length[4]|max_length[16]',
            'kartu' => [
                'rules' => 'uploaded[kartu]|max_size[kartu,1024]|is_image[kartu]|mime_in[kartu,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto KTP / Kartu Pelajar masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar'
                ]
            ],
            'selfi' => [
                'rules' => 'uploaded[selfi]|max_size[selfi,1024]|is_image[selfi]|mime_in[selfi,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto selfi bersama kartu masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar'
                ]
            ]
        ])) {
            session()->setFlashdata('error', 'Gagal aktivasi toko , Coba lagi');
            return redirect()->to(base_url('toko'))->withInput();
        }
        $db = \Config\Database::connect();
        $tokodb = $db->table('toko');
        $tokodb->where('userid', user()->id);
        $tokodb = $tokodb->get()->getFirstRow();
        $kartu = $this->request->getFile('kartu');
        $selfi = $this->request->getFile('selfi');
        $namakartu = $kartu->getRandomName();
        $namaselfi = $selfi->getRandomName();
        $kartu->move(ROOTPATH . 'img/toko/aktivasi', $namakartu);
        $selfi->move(ROOTPATH . 'img/toko/aktivasi', $namaselfi);
        $this->toko->save([
            'id' => $tokodb->id,
            'nama_rek' => $this->request->getVar('nama'),
            'no_rek' => $this->request->getVar('rekening'),
            'kartu' => $namakartu,
            'selfi' => $namaselfi
        ]);
        $admin = getadmin();

        // dd($admin);
        foreach ($admin as $admn) {
            $id_admin = $admn['iduser'];
            $adm = (object)$this->users->where('id', $id_admin)->first();

            if ($adm->telecode == 'valid') {
                $chatId = $adm->teleid;
                $pesan = 'username : ' . user()->email . '\n Toko : ' . $tokodb->username . '\n mengajukan aktivasi toko';
                kirimpesan($chatId, $pesan);
            }
        }
        $this->users->save([
            'id' => user()->id,
            'status_toko' => 2
        ]);
        session()->setFlashdata('pesan', 'Toko berhasil meminta aktivasi');
        return redirect()->to(base_url('toko'));
    }

    public function edittoko()
    {
        $toko = $this->toko->where('userid', user()->id)->first();
        $file = $this->request->getFiles();
        $status = $this->request->getVar('status');
        if ($status) {
            $status = 1;
        } else {
            $status = 0;
        }
        $selogan = $this->request->getVar('selogan');
        $gambar = $file['gambar'];
        if (!$this->validate([
            'selogan' => 'required|alpha_space|min_length[3]',
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
            $this->toko->save([
                'id' => $toko['id'],
                'selogan' => $selogan,
                'status' => $status
            ]);
        } else {
            @unlink('img/toko/' . $toko['logo']);
            $namagambar = $gambar->getRandomName();
            $gambar->move('img/toko', $namagambar);
            $this->toko->save([
                'id' => $toko['id'],
                'selogan' => $selogan,
                'status' => $status,
                'logo' => $namagambar
            ]);
        }
        session()->setFlashdata('pesan', 'Mantap , data toko berhasil di ubah');
        return redirect()->to(base_url('user/toko/pengaturan'));
    }
    //--------------------------------------------------------------------

}
