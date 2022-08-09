<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Transaksi extends BaseController
{
    public function __construct()
    {
        helper(['role', 'tele']);
        if (verifadmin() == 'invalid') {
            header("HTTP/1.1 403 Forbidden");
            header("Location: " . base_url());
            exit;
        }
    }

    public function index()
    {
        return 'cari apa bos ?';
    }

    public function berlangsung()
    {
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $keranjang->join('users', 'users.id = keranjang.buyer', 'LEFT');
        $keranjang->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $keranjang->select('keranjang.*');;
        $keranjang->select('produk.id as id_produk');
        $keranjang->select('produk.nama as nama_produk');
        $keranjang->select('users.email as email_buyer');
        $keranjang->select('toko.username as nama_toko');
        $keranjang->where('keranjang.status', 3);
        $keranjang->orwhere('keranjang.status', 5);
        $transaksi = $keranjang->findAll();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Transaksi Berlangsung | $this->namaweb",
            'transaksi' => $transaksi,
        ];
        return view('admin/transaksi_berlangsung', $data);
    }

    public function batalkan($id =0)
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
        $pesanan = $pesanan->first();
        if (!$pesanan){
            session()->setFlashdata('error', 'Transaksi tidak ditemukan');
            return redirect()->to(base_url('admin/transaksi/berlangsung'));
        }
        $this->keranjang->update(
            $id,
            [
                'pesan' => 'Dana dikembalikan',
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
        $pesan = 'Pesanan anda "'. $pesanan['nama'] .'" telah dibatalkan oleh admin, \n Tapi jangan hawatir, dana anda telah dikembalikan ke saldo';
        if ($getbuyer['telecode'] == 'valid'){
            kirimpesan($getbuyer['teleid'], $pesan);
        }
        session()->setFlashdata('pesan', 'Pesanan berhasil dibatalkan');
        return redirect()->to(base_url('admin/transaksi/berlangsung'));
    }

    public function konfirmasi($id = 0){
        $keranjang = $this->keranjang;
        $keranjang->where('keranjang.id', $id);
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
        return redirect()->to(base_url('admin/transaksi/berlangsung').'/'.$id);
    }

    public function selesai()
    {
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $keranjang->join('users', 'users.id = keranjang.buyer', 'LEFT');
        $keranjang->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $keranjang->select('keranjang.*');;
        $keranjang->select('produk.id as id_produk');
        $keranjang->select('produk.nama as nama_produk');
        $keranjang->select('users.email as email_buyer');
        $keranjang->select('toko.username as nama_toko');
        $keranjang->where('keranjang.status', 6);
        $transaksi = $keranjang->findAll();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Transaksi Selesai | $this->namaweb",
            'transaksi' => $transaksi,
        ];
        return view('admin/transaksi_selesai', $data);
    }

    public function bermasalah()
    {
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $keranjang->join('users', 'users.id = keranjang.buyer', 'LEFT');
        $keranjang->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $keranjang->select('keranjang.*');;
        $keranjang->select('produk.id as id_produk');
        $keranjang->select('produk.nama as nama_produk');
        $keranjang->select('users.email as email_buyer');
        $keranjang->select('toko.username as nama_toko');
        $keranjang->where('keranjang.status', 7);
        $transaksi = $keranjang->findAll();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Transaksi Bermasalah | $this->namaweb",
            'transaksi' => $transaksi,
        ];
        return view('admin/transaksi_bermasalah', $data);
    }

    public function refund($id =0)
    {
        $pesanan = $this->keranjang;
        $pesanan->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $pesanan->join('users', 'users.id = keranjang.buyer', 'LEFT');
        $pesanan->select('keranjang.*');
        $pesanan->select('produk.nama');
        $pesanan->select('produk.harga');
        $pesanan->select('produk.owner');
        $pesanan->where('keranjang.id', $id);
        $pesanan->where('keranjang.status', 7);
        $pesanan = $pesanan->first();
        if (!$pesanan){
            session()->setFlashdata('error', 'Pesanan tidak ditemukan');
            return redirect()->to(base_url('admin/transaksi/bermasalah'));
        }
        $this->keranjang->update(
            $id,
            [
                'pesan' => 'Di refund oleh admin',
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
        $pesan = 'Transaksi anda "'. $pesanan['nama'] .'"\n Kode : '.$pesanan['invoice'].'-'.$pesanan['id'].' \ntelah dibatalkan oleh admin, \n Tapi jangan hawatir, dana anda telah dikembalikan ke saldo';
        if ($getbuyer['telecode'] == 'valid'){
            kirimpesan($getbuyer['teleid'], $pesan);
        }
        session()->setFlashdata('pesan', 'Pesanan berhasil direfund');
        return redirect()->to(base_url('admin/transaksi/bermasalah'));
    }
}
