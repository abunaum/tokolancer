<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
class Callback extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return 'cari apa bos ?';
    }

    public function callback()
    {

        helper(['payment','tele']);
        $payment = datapayment();
        $json = file_get_contents('php://input');

    // Ambil callback signature
        $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';

    // Isi dengan private key anda
        $privateKey = $payment['apiprivatekey'];

    // Generate signature untuk dicocokkan dengan X-Callback-Signature
        $signature = hash_hmac('sha256', $json, $privateKey);

//        return $this->respond($signature, 200);

    // Validasi signature
        if ($callbackSignature !== $signature) {
            exit('Invalid signature');
        }

        $data = json_decode($json,true);

    // Hentikan proses jika callback event-nya bukan payent_status
        if ('payment_status' !== $_SERVER['HTTP_X_CALLBACK_EVENT']) {
            exit('Invalid callback event, no action was taken');
        }

        $invoice = $this->invoice;
        $invoice->where('kode', $data['merchant_ref']);
        $invoice = $invoice->findAll();
        foreach ($invoice as $i) {
            $iid = $i['id'];
            $this->invoice->update(
                $iid,
                [
                    'status' => $data['status'],
                ]
            );
        }
        $res = array(
            [
                'status' => 'success',
                'data' => $data
            ]
        );
        if ($data['status'] == 'PAID') {
            $keranjang = $this->keranjang;
            $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
            $keranjang->join('users', 'users.id = produk.owner', 'LEFT');
            $keranjang->select('keranjang.*');
            $keranjang->select('produk.nama');
            $keranjang->select('produk.owner');
            $keranjang->select('users.telecode');
            $keranjang->select('users.teleid');
            $keranjang->where('invoice', $data['merchant_ref']);
            $keranjang = $keranjang->findAll();
//        return $this->respond($keranjang, 200);
            foreach ($keranjang as $k) {
                $produk = $this->produk->where('id', $k['produk'])->first();
                $stok = $produk['stok'];
                if ($stok >= 1) {
                    $kid = $k['id'];
                    $jumlah = $k['jumlah'];
                    $this->keranjang->update(
                        $kid,
                        [
                            'status' => 3,
                        ]
                    );
                    $this->produk->update(
                        $produk['id'],
                        [
                            'stok' => $stok - $jumlah
                        ]
                    );
                    $pesan = 'Produk anda "' . $k['nama'] . '" telah dipesan dengan jumlah x' . $k['jumlah'] . ', \n stok produk anda sisa ' . ($stok - 1) . ' \n yuk cek di ' . base_url('user/toko/transaksi');
                    if ($k['telecode'] == 'valid') {
                        kirimpesan($k['teleid'], $pesan);
                    }
                }
                else {
                    $buyer = $this->users->where('id',$k['buyer'])->first();
                    $pesan = 'Produk yang anda beli "' . $k['nama'] . '" telah habis' . ', \n Tapi jangan hawatir, dana anda telah dikembalikan ke saldo';
                    $kid = $k['id'];
                    $this->keranjang->update(
                        $kid,
                        [
                            'pesan' => 'Dana dikembalikan ke saldo anda',
                            'status' => 4
                        ]
                    );
                    if ($buyer['telecode'] == 'valid') {
                        kirimpesan($buyer['teleid'], $pesan);
                    }
                }
            }
        }
        return $this->respond($res, 200);
    }
}
