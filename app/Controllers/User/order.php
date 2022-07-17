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
        helper('payment');
    }
    public function produk($id = 0)
    {
        $pesan = $this->request->getVar('pesan');
        $jumlah = $this->request->getVar('jumlah');
        $produkid = $id;
        if (!$this->validate([
            'jumlah' => 'required|is_natural_no_zero'
        ])) {
            session()->setFlashdata('error', 'Gagal membuat order , Coba lagi');

            return redirect()->to(base_url("produk/detail/$id"))->withInput();
        }
        $produk = $this->produk->where('id', $produkid)->first();
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

    public function tambahkeranjang($idp)
    {
        helper('user');
        if (!$idp){
            session()->setFlashdata('error', 'Produk tidak ditemukan');
            return redirect()->to(base_url());
        }
        $produkid = $idp;
        $produk = $this->produk->where('id', $produkid)->first();
        if ($produk['owner'] == user()->id) {
            session()->setFlashdata('error', 'Dilarang membeli produk sendiri !!!');
            return redirect()->to(base_url());
        }
        $this->keranjang->save([
            'buyer' => user()->id,
            'produk' => $produkid,
            'jumlah' => 1,
            'status' => 1
        ]);
        session()->setFlashdata('sukses', 'Produk berhasil ditambah ke keranjang');
        return redirect()->to(base_url());
    }
    public function editkeranjang($idk)
    {
        helper('user');
        $pesan = $this->request->getVar('pesan');
        $jumlah = $this->request->getVar('jumlah');
        $keranjangid = $idk;
        if (!$this->validate([
            'jumlah' => 'required|is_natural_no_zero'
        ])) {
            session()->setFlashdata('error', 'Gagal edit keranjang , Coba lagi');

            return redirect()->to(base_url("user/order/keranjang"))->withInput();
        }
        if (!$idk){
            session()->setFlashdata('error', 'Produk tidak ditemukan');
            return redirect()->to(base_url());
        }
        $this->keranjang->update(
            $keranjangid,
            [
                'pesan' => $pesan,
                'jumlah' => $jumlah,
            ]
        );
        session()->setFlashdata('sukses', 'Keranjang berhasil di edit');
        return redirect()->to(base_url('user/order/keranjang'));
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
        $keranjang->select('keranjang.status');
        $keranjang->select('toko.username as nama_toko');
        $keranjang->select('produk.id as id_produk');
        $keranjang->select('produk.nama as nama_produk');
        $keranjang->select('produk.harga as harga_produk');
        $keranjang->select('produk.gambar as gambar_produk');
        $keranjang->where('buyer', user()->id);
        $hasilkeranjang = $keranjang->where('keranjang.status', 1);
        $keranjang = $hasilkeranjang->findAll();
        $totalkeranjang = count($keranjang);
        $harga = array_column($keranjang, 'harga_produk');
        $hp = [];
        foreach ($keranjang as $k) {
            array_push($hp, $k['harga_produk'] * $k['jumlah']);
        }
        $totalharga = array_sum($hp);
        $pembayaran = getmerchantclosed(datapayment());
        $data = [
            'judul' => "keranjang | $this->namaweb",
            'item' => $item,
            'keranjang' => $keranjang,
            'totalharga' => $totalharga,
            'pembayaran' => $pembayaran,
            'totalkeranjang' => $totalkeranjang,
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
        $ovo = $this->request->getVar('noovo');
        if (!isset($channel)) {
            return redirect()->to(base_url('user/order/keranjang'));
        }
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $hasilkeranjang = $keranjang->where('buyer', user()->id);
        $keranjang = $hasilkeranjang->findAll();
        $hp = [];
        foreach ($keranjang as $k) {
            array_push($hp, $k['harga'] * $k['jumlah']);
        }
        $totalharga = array_sum($hp);
        $order_number = 'INV-'.md5(uniqid(mt_rand(), true).microtime(true));
        $item = [];
        $i =1;
        foreach ($keranjang as $k) {
            $forder = [
                'sku' => 'O'.$i.'-'.$order_number,
                'name' => $k['nama'],
                'price' => $k['harga'],
                'quantity' => $k['jumlah'],
                'product_url' => base_url('produk/detail').'/'.$k['produk'],
                'image_url' => base_url('img/produk').'/'.$k['gambar'],
            ];
            array_push($item, $forder);
            $i++;
        }
        if ($channel == 'OVO'){
            $nomor = $ovo;
        } else{
            $nomor = 'CS - 085173456771';
        }
        $proses = createtransaction(datapayment(),$item, $order_number, $channel, $totalharga, $nomor);
        $hasil = json_decode($proses,true);
        if ($hasil['success'] != true){
            session()->setFlashdata('error', 'Gagal melakukan transaksi');
            return redirect()->to(base_url('user/order/keranjang'));
        } else {
            $keranjang = $this->keranjang;
            $keranjang->where('buyer', user()->id);
            $keranjang->where('status', 1);
            $keranjang = $hasilkeranjang->findAll();
            foreach ($keranjang as $k) {
                $kid = $k['id'];
                $this->keranjang->update(
                    $kid,
                    [
                        'invoice' => $hasil['data']['merchant_ref'],
                        'status' => 2,
                    ]
                );
            }
            $invoice = $this->invoice;
            $invoice->save([
                'kode' => $hasil['data']['merchant_ref'],
                'channel' => $hasil['data']['payment_method'],
                'nominal' => $hasil['data']['amount_received'],
                'fee' => $hasil['data']['total_fee'],
                'referensi' => $hasil['data']['reference'],
                'status' => $hasil['data']['status']
            ]);
        }
        session()->setFlashdata('pesan', 'Transaksi sudah di buat, Silahkan melakukan pembayaran');
        return redirect()->to(base_url('user/order/transaksi'));
    }

    public function transaksi()
    {
        $item = $this->getitem->getsub();
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $keranjang->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $keranjang->select('keranjang.id');
        $keranjang->select('keranjang.jumlah');
        $keranjang->select('keranjang.pesan');
        $keranjang->select('keranjang.status');
        $keranjang->select('keranjang.invoice');
        $keranjang->select('toko.username as nama_toko');
        $keranjang->select('produk.id as id_produk');
        $keranjang->select('produk.nama as nama_produk');
        $keranjang->select('produk.harga as harga_produk');
        $keranjang->select('produk.gambar as gambar_produk');
        $keranjang->where('buyer', user()->id);
        $keranjang->where('keranjang.status !=', 1);
        $keranjang = $keranjang->findAll();
        foreach($keranjang as $key => $value){
            $invgroup[$value['invoice']][$key] = $value;
        }
        dd($invgroup);
    }
}
