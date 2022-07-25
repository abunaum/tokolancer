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
            'harga' => [
                'rules' => 'required|is_natural_no_zero|greater_than_equal_to[10000]',
                'errors' => [
                    'required' => 'Nominal harus ada',
                    'is_natural_no_zero' => 'Nominal tidak valid',
                    'greater_than_equal_to' => 'Minimal harga 10000',
                ]
            ],
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

    public function hapusproduk($id = 0)
    {
        $produk = $this->produk->where('id', $id)->get()->getFirstRow();
        if (!$produk){
            session()->setFlashdata('error', 'Produk tidak ditemukan');
            return redirect()->to(base_url('toko'));
        }
        if ($produk->owner != user()->id) {
            session()->setFlashdata('error', 'Produk tidak ditemukan');
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
            'harga' => [
                'rules' => 'required|is_natural_no_zero|greater_than_equal_to[10000]',
                'errors' => [
                    'required' => 'Nominal harus ada',
                    'is_natural_no_zero' => 'Nominal tidak valid',
                    'greater_than_equal_to' => 'Minimal harga 10000',
                ]
            ],
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
        $riwayat->where('keranjang.status !=', 7);
        $riwayat->where('produk.owner', user()->id);
        $riwayat = $riwayat->orderBy('created_at','DESC')->findAll();

        $transaksibermasalah = $this->kirimpesanan;
        $transaksibermasalah->join('keranjang', 'keranjang.id = pesanan_dikirim.keranjang', 'LEFT');
        $transaksibermasalah->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $transaksibermasalah->select('pesanan_dikirim.*');
        $transaksibermasalah->select('keranjang.invoice');
        $transaksibermasalah->select('produk.nama');
        $transaksibermasalah->select('keranjang.jumlah');
        $transaksibermasalah->select('produk.owner');
        $transaksibermasalah->where('keranjang.status', 7);
        $transaksibermasalah->where('produk.owner', user()->id);
        $transaksibermasalah = $transaksibermasalah->orderBy('created_at','DESC')->findAll();
//        dd($riwayat);

        $data = [
            'judul' => "Transaksi | $this->namaweb",
            'item' => $item,
            'paid' => $paid,
            'total_paid' => $totalpaid,
            'riwayat' => $riwayat,
            'bermasalah' => $transaksibermasalah
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

    public function saldo()
    {
        $config = ambilconfig();
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $toko->where('userid', user()->id);
        $toko= $toko->first();
        $pencairan = $this->transaksi_saldo;
        $pencairan->where('user', user()->id);
        $pencairan->where('status', 1);
        $pencairan = $pencairan->findAll();
        $data = [
            'judul' => "Saldo toko | $this->namaweb",
            'item' => $item,
            'toko' => $toko,
            'cair' => $config['cair'],
            'pencairan' => $pencairan,
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/user/saldotoko', $data);
    }
    public function cairkan()
    {
        $config = ambilconfig();
        $cair = $config['cair'];
        $nominal = $this->request->getVar('nominal');

        if (!$this->validate([
            'nominal' => [
                'rules' => 'required|is_natural_no_zero|greater_than_equal_to[50000]',
                'errors' => [
                    'required' => 'Nominal harus ada',
                    'is_natural_no_zero' => 'Nominal tidak valid',
                    'greater_than_equal_to' => 'Nominal error',
                ],
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal request pencairan dana');
            return redirect()->to(base_url('user/toko/saldo'))->withInput();
        }
        $bisadicairkan = user()->balance - $cair['fee'];
        if ($nominal > $bisadicairkan){
            session()->setFlashdata('error', 'Nominal tidak valid');
            return redirect()->to(base_url('user/toko/saldo'));
        } elseif ($nominal < $cair['minimal']){
            session()->setFlashdata('error', 'Nominal tidak valid');
            return redirect()->to(base_url('user/toko/saldo'));
        } elseif ($bisadicairkan < $cair['minimal']){
            session()->setFlashdata('error', 'Nominal tidak valid');
            return redirect()->to(base_url('user/toko/saldo'));
        } else {
            $transaksi = $this->transaksi_saldo;
            $transaksi->save(
                [
                    'user' => user()->id,
                    'nominal' => $nominal,
                    'fee'=> $cair['fee'],
                    'status' => 1,
                    'keterangan' => 'Pencairan sedang di proses'
                ]
            );
            $newbalance = user()->balance - ($nominal + $cair['fee']);
            $this->users->update(
                user()->id,
                [
                    'balance'=>$newbalance
                ]
            );
            if (user()->telecode == 'valid'){
                $pesanuser = 'Pencairan dana '. number_to_currency($nominal, 'IDR', 'id_ID', 0).' sedang di proses, saldo anda sekarang '. number_to_currency(user()->balance, 'IDR', 'id_ID', 0);
                kirimpesan(user()->teleid, $pesanuser);
            }
            $toko = $this->toko->where('userid', user()->id)->first();
            $admin = getadmin();
            foreach ($admin as $admn) {
                $id_admin = $admn['iduser'];
                $min = $this->users->where('id', $id_admin)->get()->getFirstRow();
                if($min->telecode == 'valid'){
                    $chatId = $min->teleid;
                    $pesan = user()->email . '\n Melakukan request pencairan saldo : \nNominal : ' . number_to_currency($nominal, 'IDR', 'id_ID', 0) . '\nMetode : ' . $toko['metode'] . '\nNo Rekening : ' . $toko['no_rek'].'\nAtas Nama : '.$toko['nama_rek'];
                    kirimpesan($chatId, $pesan);
                }
            }
            session()->setFlashdata('pesan', 'Berhasil mengajukan pencairan dana');
            return redirect()->to(base_url('user/toko/saldo'));
        }
    }

    public function riwayat_pencairan()
    {
        $item = $this->getitem->getsub();
        $pencairan = $this->transaksi_saldo;
        $pencairan->where('user', user()->id);
        $pencairan->where('status !=', 1);
        $pencairan = $pencairan->orderBy('created_at','DESC')->findAll();
        $data = [
            'judul' => "Riwayat pencairan | $this->namaweb",
            'item' => $item,
            'pencairan' => $pencairan
        ];
        return view('halaman/user/riwayat_pencairan', $data);
    }
}
