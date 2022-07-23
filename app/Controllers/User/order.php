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
        helper(['payment','tele']);
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
        $hasilkeranjang = $keranjang->where('status', 1);
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
        $newinv = $this->invoice;
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
        $keranjang->where('keranjang.status', 2);
        $keranjang = $keranjang->findAll();
        $invgroup = [];
        foreach($keranjang as $value){
            $invgroup[$value['invoice']][] = $value;
        }
        $invgr = [];
        foreach ($invgroup as $type => $labels) {
            $tr = $newinv->where('kode', $type)->first();
            $invgr[] = [
                'kode' => $type,
                'payment' => $tr,
                'data' => $labels,
            ];
        }

        $paid = $this->keranjang;
        $paid->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $paid->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $paid->select('keranjang.id');
        $paid->select('keranjang.jumlah');
        $paid->select('keranjang.pesan');
        $paid->select('keranjang.status');
        $paid->select('keranjang.invoice');
        $paid->select('toko.username as nama_toko');
        $paid->select('produk.id as id_produk');
        $paid->select('produk.nama as nama_produk');
        $paid->select('produk.harga as harga_produk');
        $paid->select('produk.gambar as gambar_produk');
        $paid->where('buyer', user()->id);
        $paid->where('keranjang.status !=', 1);
        $paid->where('keranjang.status !=', 2);
        $paid->orderBy('keranjang.updated_at', 'DESC');
        $paid = $paid->findAll();

        $paidgroup = [];
        foreach($paid as $value){
            $paidgroup[$value['status']][] = $value;
        }
        $lunas = array_filter($paidgroup, function ($key) {
            return $key == '3';
        }, ARRAY_FILTER_USE_KEY);

        $tolak = array_filter($paidgroup, function ($key) {
            return $key == '4';
        }, ARRAY_FILTER_USE_KEY);

        $kirim = array_filter($paidgroup, function ($key) {
            return $key == '5';
        }, ARRAY_FILTER_USE_KEY);

        $selesai = array_filter($paidgroup, function ($key) {
            return $key == '6';
        }, ARRAY_FILTER_USE_KEY);

        $bermasalah = array_filter($paidgroup, function ($key) {
            return $key == '7';
        }, ARRAY_FILTER_USE_KEY);
        $data = [
            'judul' => "Invoice | $this->namaweb",
            'item' => $item,
            'invoice' => $invgr,
            'transaksi' => $lunas,
            'tolak' => $tolak,
            'kirim' =>$kirim,
            'selesai' => $selesai,
            'bermasalah' => $bermasalah,
            'total_invoice' => count($invgr)
        ];

        return view('halaman/user/invoice', $data);
    }

    public function bayar($id = 0)
    {
        $inv = $this->invoice->where('id', $id)->first();
        $cek = json_decode(detailtransaksi(datapayment(),$inv['referensi']), true);
        if ($cek['success'] != true){
            session()->setFlashdata('error', 'Terjadi kesalahan');
            return redirect()->to(base_url('user/order/transaksi'));
        } else {
            return redirect()->to($cek['data']['checkout_url']);
        }
    }

    public function hapusinvoice($id =0)
    {
        $inv = $this->invoice->where('id', $id)->first();
        $kode = $inv['kode'];
        $this->keranjang->where('invoice', $inv['kode'])->delete();
        $this->keranjang->where('invoice', $inv['kode'])->purgeDeleted();
        $this->invoice->where('id', $id)->delete();
        $this->invoice->where('id', $id)->purgeDeleted();
        session()->setFlashdata('pesan', 'Transaksi '. $kode . 'sudah di hapus');
        return redirect()->to(base_url('user/order/transaksi'));
    }
    public function hapustransaksi($id =0)
    {
        $cek = $this->keranjang;
        $cek = $cek->where('id', $id)->first();
        if ($cek['buyer'] != user()->id) {
            return redirect()->to(base_url('user/order/trannsaksi'));
        }
        $keranjang = $this->keranjang;
        $keranjang->where('id', $id);
        $keranjang->where('status', 4);
        $keranjang->orwhere('status', 6);
        $keranjang->delete();
        session()->setFlashdata('pesan', 'Transaksi berhasil di hapus');
        return redirect()->to(base_url('user/order/transaksi'));
    }
    public function canceltransaksi($id =0)
    {
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $keranjang->select('keranjang.*');
        $keranjang->select('produk.nama');
        $keranjang->select('produk.harga');
        $keranjang->where('keranjang.id', $id);
        $keranjang->where('keranjang.status', 3);
        $keranjang = $keranjang->first();
        if (!$keranjang){
            session()->setFlashdata('error', 'Terjadi kesalahan');
            return redirect()->to(base_url('user/order/transaksi'));
        }
        if ($keranjang['buyer'] != user()->id) {
            return redirect()->to(base_url('user/order/trannsaksi'));
        }
        $getbuyer = $this->users->where('id', $keranjang['buyer'])->first();
        $balance = $getbuyer['balance'];
        $this->users->update(
            $keranjang['buyer'],
            [
                'balance' => $balance + ($keranjang['harga'] * $keranjang['jumlah'])
            ]
        );
        $pesan = 'Pesanan anda "'. $keranjang['nama'] .'" telah dibatalkan, \n Tapi jangan hawatir, dana anda telah dikembalikan ke saldo';
        if ($getbuyer['telecode'] == 'valid'){
            kirimpesan($getbuyer['teleid'], $pesan);
        }
        $this->keranjang->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Transaksi berhasil di batalkan');
        return redirect()->to(base_url('user/order/transaksi'));
    }

    public function detailtransaksi($id = 0)
    {
//        dd($id);
        $item = $this->getitem->getsub();
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $keranjang->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $keranjang->join('pesanan_dikirim', 'pesanan_dikirim.keranjang = keranjang.id', 'LEFT');
        $keranjang->select('keranjang.*');
        $keranjang->select('produk.nama');
        $keranjang->select('produk.gambar');
        $keranjang->select('produk.harga');
        $keranjang->select('toko.username');
        $keranjang->select('pesanan_dikirim.status as status_kiriman');
        $keranjang->select('pesanan_dikirim.nominal as nominal_transaksi');
        $keranjang->select('pesanan_dikirim.detail');
        $keranjang->where('keranjang.id', $id);
        $keranjang->where('keranjang.buyer', user()->id);
        $keranjang->where('keranjang.status !=', 1);
        $keranjang->where('keranjang.status !=', 2);
        $keranjang->where('keranjang.status !=', 3);
        $keranjang->where('keranjang.status !=', 4);
        $transaksi = $keranjang->first();
        if (!$transaksi){
            session()->setFlashdata('error', 'Transaksi tidak ditemukan');
            return redirect()->to(base_url('user/order/transaksi'));
        }
        $data = [
            'judul' => "Invoice | $this->namaweb",
            'item' => $item,
            'transaksi' => (object)$transaksi
        ];

        return view('halaman/user/detailtransaksi', $data);
    }

    public function updatetransaksi($id = 0){
        $keranjang = $this->keranjang;
        $keranjang->where('keranjang.id', $id);
        $keranjang->where('keranjang.buyer', user()->id);
        $transaksi = $keranjang->first();
        if (!$transaksi){
            session()->setFlashdata('error', 'Transaksi tidak ditemukan');
            return redirect()->to(base_url('user/order/transaksi'));
        }
        $kirim = $this->kirimpesanan;
        $pesanan = $kirim->where('keranjang', $id)->first();
        if (!$pesanan){
            session()->setFlashdata('error', 'Transaksi tidak ditemukan');
            return redirect()->to(base_url('user/order/transaksi'));
        }
        $this->kirimpesanan->update(
            $pesanan['id'],
            [
                'status' => 2
            ]
        );
        session()->setFlashdata('pesan', 'Transaksi tidak ditemukan');
        return redirect()->to(base_url('user/order/detailtransaksi').'/'.$id);
    }

    public function transaksiselesai($id = 0){
        $keranjang = $this->keranjang;
        $keranjang->where('keranjang.id', $id);
        $keranjang->where('keranjang.buyer', user()->id);
        $transaksi = $keranjang->first();
        if (!$transaksi){
            session()->setFlashdata('error', 'Transaksi tidak ditemukan');
            return redirect()->to(base_url('user/order/transaksi'));
        }
        $kirim = $this->kirimpesanan;
        $pesanan = $kirim->where('keranjang', $id)->first();
        if (!$pesanan){
            session()->setFlashdata('error', 'Transaksi tidak ditemukan');
            return redirect()->to(base_url('user/order/transaksi'));
        }
        $this->keranjang->update(
            $id,
            [
                'status' => 6
            ]
        );
        $this->kirimpesanan->update(
            $pesanan['id'],
            [
                'status' => 3
            ]
        );
        $getseller = $this->keranjang;
        $getseller->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $getseller->join('users', 'users.id = produk.owner', 'LEFT');
        $keranjang->join('pesanan_dikirim', 'pesanan_dikirim.keranjang = keranjang.id', 'LEFT');
        $getseller->select('keranjang.*');
        $getseller->select('pesanan_dikirim.*');
        $getseller->select('produk.owner');
        $getseller->select('users.teleid');
        $getseller->select('users.telecode');
        $seller= $getseller->where('keranjang.id', $id);
        $seller = $seller->first();


        $fee = file_get_contents(ROOTPATH . "config.json");
        $config = json_decode($fee, TRUE);
        $fee = $config['feemc'];

        $dataseller = $this->users->where('id', $seller['owner'])->first();
        $saldoseller = $dataseller['balance'];
        $saldotambahan = $seller['nominal'] - ($seller['nominal']*($fee['percent']/100));

        $pesan = 'Transaksi dengan kode "' . $seller['invoice'] . '" telah selesai. \n'.number_to_currency($saldotambahan, 'IDR', 'id_ID', 0).' ('.number_to_currency($seller['nominal'], 'IDR', 'id_ID', 0).' - '.$fee['percent'].'%) telah ditambahkan ke saldo anda. \n'.'Total saldo saat ini '. number_to_currency($saldoseller+$saldotambahan, 'IDR', 'id_ID', 0);
        if ($seller['telecode'] == 'valid') {
            kirimpesan($seller['teleid'], $pesan);
        }
        $this->users->update(
            $seller['owner'],
            [
                'balance' =>$saldoseller+$saldotambahan
            ]
        );
        session()->setFlashdata('pesan', 'Dana berhasil dilepaskan ke seller');
        return redirect()->to(base_url('user/order/detailtransaksi').'/'.$id);
    }

    public function transaksibermasalah($id = 0)
    {
        $keranjang = $this->keranjang;
        $keranjang->where('keranjang.id', $id);
        $keranjang->where('keranjang.buyer', user()->id);
        $transaksi = $keranjang->first();
        if (!$transaksi){
            session()->setFlashdata('error', 'Transaksi tidak ditemukan');
            return redirect()->to(base_url('user/order/transaksi'));
        }
        $kirim = $this->kirimpesanan;
        $pesanan = $kirim->where('keranjang', $id)->first();
        if (!$pesanan){
            session()->setFlashdata('error', 'Transaksi tidak ditemukan');
            return redirect()->to(base_url('user/order/transaksi'));
        }
        $this->keranjang->update(
            $id,
            [
                'status' => 7
            ]
        );
        $this->kirimpesanan->update(
            $pesanan['id'],
            [
                'status' => 4
            ]
        );
        $getseller = $this->keranjang;
        $getseller->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $getseller->join('users', 'users.id = produk.owner', 'LEFT');
        $keranjang->join('pesanan_dikirim', 'pesanan_dikirim.keranjang = keranjang.id', 'LEFT');
        $getseller->select('keranjang.*');
        $getseller->select('pesanan_dikirim.*');
        $getseller->select('produk.owner');
        $getseller->select('users.teleid');
        $getseller->select('users.telecode');
        $seller= $getseller->where('keranjang.id', $id);
        $seller = $seller->first();

        $kode = $transaksi['invoice'].'-'.$transaksi['id'];
        $pesan = 'Transaksi dengan kode "' . $seller['invoice'] . '" bermasalah. \n Harap segera hubungi CS \n kode transaksi : '. $kode;
        if ($seller['telecode'] == 'valid') {
            kirimpesan($seller['teleid'], $pesan);
        }
        $pesanbuyer = 'Transaksi dengan kode "' . $seller['invoice'] . '" bermasalah. \n Harap segera hubungi CS \n kode transaksi : '. $kode;
        if (user()->telecode == 'valid') {
            kirimpesan(user()->teleid, $pesan);
        }

        session()->setFlashdata('pesan', 'Dana berhasil ditahan, Harap segera hubungi CS');
        return redirect()->to(base_url('user/order/detailtransaksi').'/'.$id);
    }
}
