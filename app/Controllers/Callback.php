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

        helper('payment');
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

        $keranjang = $this->keranjang;
        $keranjang->where('invoice', $data['merchant_ref']);
        $keranjang = $keranjang->findAll();
        foreach ($keranjang as $k) {
            $kid = $k['id'];
            $this->keranjang->update(
                $kid,
                [
                    'status' => 3,
                ]
            );
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
        return $this->respond($res, 200);
    }
}
