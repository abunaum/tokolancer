<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\TeleApiLibrary;
use App\Libraries\Itemlibrary;
use App\Libraries\PaymentApiLibrary;

class order extends BaseController
{
    public $apilib;

    public function __construct()
    {
        $this->apilib = new PaymentApiLibrary();
        $this->getitem = new Itemlibrary();
    }
    public function produk($id = 0)
    {
        $pesan = $this->request->getVar('pesan');
        $jumlah = $this->request->getVar('jumlah');
        if (!$this->validate([
            'jumlah' => 'required|is_natural_no_zero'
        ])) {
            session()->setFlashdata('error', 'Gagal membuat order , Coba lagi');

            return redirect()->to(base_url("produk/detail/$id"))->withInput();
        }
        $produk = $this->produk;
        $produk = (object)$produk->detail($id)->first();
        $order = [
            'order'  => [
                'id_produk' => $id,
                'pesan' => $pesan,
                'jumlah' => $jumlah
            ]
        ];

        session()->set($order);
        return redirect()->to(base_url('user/order/produk'));
    }

    public function order()
    {
        $order = session('order');
        if (!isset($order)) {
            return redirect()->to(base_url("user/order/keranjang"));
        }
        $produkid = $order['id_produk'];
        $pesan = $order['pesan'];
        $jumlah = $order['jumlah'];
        session()->remove('order');
        $produk = $this->produk->detail($produkid)->first();
        if ($produk['owner'] == user()->id) {
            session()->setFlashdata('error', 'Dilarang membeli produk sendiri !!!');
            return redirect()->to(base_url("produk/detail/$produkid"));
        }
        $this->keranjang->save([
            'buyer' => user()->id,
            'produk' => $produkid,
            'jumlah' => $jumlah,
            'pesan' => $pesan,
            'status' => 1
        ]);
        session()->setFlashdata('pesan', 'Produk berhasil ditambah ke keranjang');
        return redirect()->to(base_url("produk/detail/$produkid"));
    }

    public function keranjang()
    {
        $item = $this->getitem->getsub();
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $keranjang->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $keranjang->select('keranjang.id');
        $keranjang->select('keranjang.jumlah');
        $keranjang->select('keranjang.pesan');
        $keranjang->select('toko.username as nama_toko');
        $keranjang->select('produk.id as id_produk');
        $keranjang->select('produk.nama as nama_produk');
        $keranjang->select('produk.harga as harga_produk');
        $keranjang->select('produk.gambar as gambar_produk');
        $hasilkeranjang = $keranjang->where('buyer', user()->id);
        $keranjang = $hasilkeranjang->findAll();
        $totalkeranjang = $hasilkeranjang->countAllResults();
        $harga = array_column($keranjang, 'harga_produk');
        $totalharga = array_sum($harga);
        $pembayaran = $this->apilib->getmerchantclosed();
        $data = [
            'judul' => "keranjang | $this->namaweb",
            'item' => $item,
            'keranjang' => $keranjang,
            'totalharga' => $totalharga,
            'pembayaran' => $pembayaran,
            'totalkeranjang' => $totalkeranjang,
            'paymentapi' => $this->apilib,
        ];

        return view('halaman/user/keranjang', $data);
    }

    public function hapuskeranjang($id = 0)
    {
        $keranjang = $this->keranjang->where('id', $id)->first();
        if ($keranjang['buyer'] != user()->id) {
            return redirect()->to(base_url('user/order/keranjang'));
        } else {
            $this->keranjang->delete($id);
            $this->keranjang->where('id', $id)->purgeDeleted();
        }
        session()->setFlashdata('pesan', 'Produk berhasil dihapus dari keranjang');
        return redirect()->to(base_url('user/order/keranjang'));
    }

    public function hapussemuakeranjang()
    {
        $this->keranjang->where('buyer', user()->id)->delete();
        $this->keranjang->where('buyer', user()->id)->purgeDeleted();
        session()->setFlashdata('pesan', 'Keranjang sudah kosong');
        return redirect()->to(base_url('user/order/keranjang'));
    }

    public function proseskeranjang()
    {
        $channel = $this->request->getVar('metode');
        if (!isset($channel)) {
            return redirect()->to(base_url('user/order/keranjang'));
        }
        echo $channel;
    }
}
