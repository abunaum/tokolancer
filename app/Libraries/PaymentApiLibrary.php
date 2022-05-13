<?php

namespace App\Libraries;

use App\Controllers\BaseController;

class PaymentApiLibrary extends BaseController
{
    public $apilib;
    public function __construct()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('apipayment');
        $builder->where('id', 1);
        $apidb = $builder->get()->getFirstRow();
        $this->apikey = $apidb->apikey;
        $this->apiprivatekey = $apidb->apiprivatekey;
        $this->kodemerchant = $apidb->kodemerchant;
        $this->urlcreatepayment = $apidb->urlcreatepayment;
        $this->urlpaymentchannel = $apidb->urlpaymentchannel;
        $this->urlfeekalkulator = $apidb->urlfeekalkulator;
        $this->detailtransaksiurl = $apidb->urldetailtransaksi;
        $this->callback = 'http://9f0d3ba5b1fb.ngrok.io/' . $apidb->callback;
    }
    public function getmerchant()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->urlpaymentchannel,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $datapembayaran = $data['data'];
        curl_close($curl);
        return $datapembayaran;
    }

    public function getmerchantclosed()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->urlpaymentchannel,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $datapembayaran = $data['data'];
        curl_close($curl);
        $merchant = array();
        foreach ($datapembayaran as $dp) {
            if (strpos($dp['name'], '(Open Payment)') != true) {
                $merchant[] = array('nama' => $dp['name'], 'code' => $dp['code'], 'flat' => $dp['fee']['flat'], 'percent' => $dp['fee']['percent']);
            }
        }
        return $merchant;
    }

    public function getmerchantopen()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->urlpaymentchannel,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $datapembayaran = $data['data'];
        curl_close($curl);
        $merchant = array();
        foreach ($datapembayaran as $dp) {
            if (strpos($dp['name'], '(Open Payment)') != false) {
                $merchant[] = array('nama' => $dp['name'], 'code' => $dp['code'], 'flat' => $dp['fee']['flat'], 'percent' => $dp['fee']['percent']);
            }
        }
        return $merchant;
    }
    public function paymentkalkulator($channel, $saldo)
    {
        $payload = [
            'code'    => $channel,
            'amount'    => $saldo
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->urlfeekalkulator . http_build_query($payload),
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);

        curl_close($curl);
        return $data['data'][0]['total_fee'];
    }

    public function createtransaction($dataitem, $order_number, $channel, $totalbayar)
    {
        $data = [
            'method'            => $channel,
            'merchant_ref'      => $order_number,
            'amount'            => $totalbayar,
            'customer_name'     => user()->username,
            'customer_email'    => user()->email,
            'customer_phone'    => 'CS - 085155118423',
            'order_items'       => $dataitem,
            'callback_url'      => $this->callback,
            'return_url'        => base_url('user/saldo/topup'),
            'expired_time'      => (time() + (24 * 60 * 60)), // 24 jam
            'signature'         => hash_hmac('sha256', $this->kodemerchant . $order_number . $totalbayar, $this->apiprivatekey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->urlcreatepayment,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false,
            CURLOPT_POST              => true,
            CURLOPT_POSTFIELDS        => http_build_query($data)
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $createpayment = json_decode($response, true);
        $createpayment = json_encode($createpayment);
        return $createpayment;
    }

    public function detailtransaksi($referensi)
    {
        $payload = [
            'reference'    => $referensi
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->detailtransaksiurl . http_build_query($payload),
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $detailpayment = json_decode($response, true);
        $detailpayment = json_encode($detailpayment);
        return $detailpayment;
    }
}
