<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\Itemlibrary;
use CodeIgniter\API\ResponseTrait;

class toko extends BaseController
{

    public function __construct()
    {
        helper(['role','tele']);
        $this->getitem = new Itemlibrary();
    }

    use ResponseTrait;

    public function produk()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $produkuser = $this->produk->where('owner', user()->id);
        // dd($produkuser->findAll());

        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item,
            'toko' => $toko->where('userid', user()->id)->get()->getFirstRow(),
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'produk' => $produkuser->paginate(6),
            'pager' => $produkuser->pager,
        ];
        if ($user->status_toko != 4) {
            return redirect()->to(base_url('toko'));
        } else {
            return view('Toko/fitur/produk', $data);
        }
    }

    public function tambah()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $itemproduk = $this->item;
        $data = [
            'type' => 'tambahproduk',
            'judul' => "Tambah Produk | $this->namaweb",
            'item' => $item,
            'itemproduk' => $itemproduk->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('userid', user()->id)->get()->getFirstRow(),
            'user' => $user,
            'validation' => \Config\Services::validation(),
        ];
        if ($user->status_toko != 4) {
            return redirect()->to(base_url('toko'));
        } else {
            return view('Toko/fitur/tambah', $data);
        }
    }

    public function tambahproduk()
    {
        $subitem = $this->request->getVar('sub');
        $nama = $this->request->getVar('nama');
        $harga = (int) $this->request->getVar('harga');
        $deskripsi = $this->request->getVar('deskripsi');
        $stok = $this->request->getVar('stok');

        $toko = $this->toko->where('userid', user()->id)->get()->getFirstRow();
        $slug = url_title($toko->username . ' ' . $nama);

        if (!$this->validate([
            'item' => 'required',
            'sub' => 'required',
            'nama' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar produk masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 2 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar',
                ],
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal menambah produk');
            return redirect()->to(base_url('user/toko/tambah'))->withInput();
        }
        $gambar = $this->request->getFile('gambar');
        $gambar->move('img/produk');
        $namagambar = $gambar->getName();
        $produk = $this->produk;
        $produk->save([
            'jenis' => $subitem,
            'owner' => user()->id,
            'gambar' => $namagambar,
            'nama' => $nama,
            'harga' => $harga,
            'keterangan' => $deskripsi,
            'slug' => $slug,
            'stok' => $stok,
        ]);

        $admin = getadmin();
        foreach ($admin as $admn) {
            $id_admin = $admn['iduser'];
            $min = $this->users->where('id', $id_admin)->get()->getFirstRow();
            if($min->telecode == 'valid'){
                $chatId = $min->teleid;
                $pesan = user()->email . '\nToko : ' . $toko->username . '\nmenambah produk :' . $nama . '\nharga : ' . $harga;
                kirimpesan($chatId, $pesan);
            }
        }
        session()->setFlashdata('pesan', 'Produk berhasil di tambah');
        return redirect()->to(base_url('user/toko/produk'));
    }

    public function produkdetail($id = 0)
    {
        $produk = $this->produk->where('id', $id)->get()->getFirstRow();
        $item = $this->getitem->getsub();
        $toko = $this->toko->where('userid', user()->id)->get()->getFirstRow();
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $produkuser = $this->produk->where('owner', user()->id);
        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item,
            'toko' => $toko,
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'produk' => $produk,
            'produkuser' => $produkuser->paginate(6),
            'pager' => $produkuser->pager,
        ];
        if ($toko == null) {
            return redirect()->to(base_url('toko'));
        } elseif ($toko->userid != user()->id) {
            return redirect()->to(base_url('toko'));
        } elseif (user()->status_toko != 4) {
            return redirect()->to(base_url('toko'));
        } else {
            return view('Toko/fitur/produkdetail', $data);
        }
    }

    public function hapusproduk($id)
    {
        $produk = $this->produk->where('id', $id)->get()->getFirstRow();
        if ($produk->owner != user()->id) {
            return redirect()->to(base_url('toko'));
        } else {
            $this->produk->delete($id);
            session()->setFlashdata('pesan', 'Produk Berhasil di hapus');
            return redirect()->to(base_url('user/toko/produk'));
        }
    }
    public function editproduk($id)
    {
        $produk = $this->produk->find($id);
        if ($produk['owner'] != user()->id) {
            return redirect()->to(base_url('user/toko/produk'));
        }
        $file = $this->request->getFiles();
        $gambar = $file['gambar'];
        $nama = $this->request->getVar('nama');
        $keterangan = $this->request->getVar('keterangan');
        $harga = (int)$this->request->getVar('harga');
        $stok = (int)$this->request->getVar('stok');
        if (!$this->validate([
            'nama' => 'required|alpha_numeric_punct|min_length[3]',
            'keterangan' => 'required',
            'harga' => 'required|is_natural|min_length[1]',
            'stok' => 'required|is_natural|min_length[1]',
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar',
                ],
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal mengubah produk , Coba lagi');
            return redirect()->to(base_url('user/toko/produk/detail') . '/' . $id)->withInput();
        }
        if ($gambar->getError() == 4) {
            $this->produk->update(
                $id,
                [
                'nama' => $nama,
                'keterangan' => $keterangan,
                'harga' => $harga,
                'stok' => $stok
            ]);
        } else {
            @unlink('img/produk/' . $produk['gambar']);
            $namagambar = $gambar->getRandomName();
            $gambar->move('img/produk', $namagambar);
            $this->produk->update(
                $id,
                [
                'nama' => $nama,
                'keterangan' => $keterangan,
                'harga' => $harga,
                'gambar' => $namagambar,
                'stok' => $stok
            ]);
        }
        session()->setFlashdata('pesan', 'Mantap , produk berhasil di ubah');
        return redirect()->to(base_url('user/toko/produk/detail') . '/' . $id);
    }
    public function pengaturan()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $data = [
            'judul' => "Pengaturan toko | $this->namaweb",
            'item' => $item,
            'toko' => $toko->where('userid', user()->id)->first(),
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/user/pengaturantoko', $data);
    }
    public function transaksi()
    {
        $item = $this->getitem->getsub();
        $paid = $this->keranjang;
        $paid->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $paid->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $paid->join('users', 'users.id = keranjang.buyer', 'LEFT');
        $paid->select('keranjang.id');
        $paid->select('keranjang.buyer');
        $paid->select('keranjang.jumlah');
        $paid->select('keranjang.pesan');
        $paid->select('keranjang.status');
        $paid->select('keranjang.invoice');
        $paid->select('toko.username as nama_toko');
        $paid->select('produk.id as id_produk');
        $paid->select('produk.owner');
        $paid->select('produk.nama as nama_produk');
        $paid->select('produk.harga as harga_produk');
        $paid->select('produk.gambar as gambar_produk');
        $paid->select('users.email as email_buyer');
        $paid->where('produk.owner', user()->id);
        $paid->where('keranjang.status', 3);
        $paid = $paid->findAll();
        $totalpaid = count($paid);

        $riwayat = $this->kirimpesanan;
        $riwayat->join('keranjang', 'keranjang.id = pesanan_dikirim.keranjang', 'LEFT');
        $riwayat->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $riwayat->select('pesanan_dikirim.*');
        $riwayat->select('keranjang.invoice');
        $riwayat->select('produk.nama');
        $riwayat->select('keranjang.jumlah');
        $riwayat->select('produk.owner');
        $riwayat->where('produk.owner', user()->id);
        $riwayat = $riwayat->orderBy('created_at','DESC')->findAll();
//        dd($riwayat);

        $data = [
            'judul' => "Transaksi | $this->namaweb",
            'item' => $item,
            'paid' => $paid,
            'total_paid' => $totalpaid,
            'riwayat' => $riwayat
        ];
        return view('Toko/transaksi/listtransaksi', $data);
    }

    public function batalkanpesanan($id =0)
    {
        $pesanan = $this->keranjang;
        $pesanan->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $pesanan->join('users', 'users.id = keranjang.buyer', 'LEFT');
        $pesanan->select('keranjang.*');
        $pesanan->select('produk.nama');
        $pesanan->select('produk.harga');
        $pesanan->select('produk.owner');
        $pesanan->where('keranjang.id', $id);
        $pesanan->where('keranjang.status', 3);
        $pesanan->where('produk.owner', user()->id);
        $pesanan = $pesanan->first();
//        dd($pesanan);
        if (!$pesanan){
            session()->setFlashdata('error', 'Pesanan tidak ditemukan');
            return redirect()->to(base_url('user/toko/transaksi'));
        }
        $this->keranjang->update(
            $id,
            [
                'pesan' => 'Dana dikembalikan ke saldo anda',
                'status' => 4
            ]
        );
        $getbuyer = $this->users->where('id', $pesanan['buyer'])->first();
        $balance = $getbuyer['balance'];
        $this->users->update(
            $pesanan['buyer'],
            [
                'balance' => $balance + ($pesanan['harga'] * $pesanan['jumlah'])
            ]
        );
        $pesan = 'Pesanan anda "'. $pesanan['nama'] .'" telah dibatalkan oleh seller, \n Tapi jangan hawatir, dana anda telah dikembalikan ke saldo';
        if ($getbuyer['telecode'] == 'valid'){
            kirimpesan($getbuyer['teleid'], $pesan);
        }
        session()->setFlashdata('pesan', 'Pesanan berhasil dibatalkan');
        return redirect()->to(base_url('user/toko/transaksi'));
    }

    public function kirimproduk($id = 0){
        $detail = $this->request->getVar('pesan');
        $pesanan = $this->keranjang;
        $pesanan->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $pesanan->join('users', 'users.id = keranjang.buyer', 'LEFT');
        $pesanan->select('keranjang.*');
        $pesanan->select('produk.nama');
        $pesanan->select('produk.harga');
        $pesanan->select('produk.owner');
        $pesanan->where('keranjang.id', $id);
        $pesanan->where('keranjang.status', 3);
        $pesanan->where('produk.owner', user()->id);
        $pesanan = $pesanan->first();
        if (!$pesanan){
            session()->setFlashdata('error', 'Pesanan tidak ditemukan');
            return redirect()->to(base_url('user/toko/transaksi'));
        }
        $this->keranjang->update(
            $id,
            [
                'pesan' => 'Pesanan dikirim, Menunggu respon buyer',
                'status' => 5
            ]
        );
        $this->kirimpesanan->save([
            'keranjang' => $pesanan['id'],
            'nominal' => $pesanan['harga']*$pesanan['jumlah'],
            'detail' => $detail,
            'status' => 1
        ]);
        $getbuyer = $this->users->where('id', $pesanan['buyer'])->first();
        $pesanbuyer = 'Pesanan anda "'. $pesanan['nama'] .'" telah dikirim oleh seller, \n silahkan cek pesanan anda di'. base_url('user/order/transaksi');
        if ($getbuyer['telecode'] == 'valid'){
            kirimpesan($getbuyer['teleid'], $pesanbuyer);
        }
        session()->setFlashdata('pesan', 'Pesanan berhasil dikirim');
        return redirect()->to(base_url('user/toko/transaksi'));
    }
}
