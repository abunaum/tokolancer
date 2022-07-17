<?php
function datapayment()
{
    $data = file_get_contents(ROOTPATH . "config.json");
    $config = json_decode($data, TRUE);
    $data = $config['payment'];
    return $data;
}
function getmerchant($payment)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_FRESH_CONNECT     => true,
        CURLOPT_URL               => $payment['urlpaymentchannel'],
        CURLOPT_RETURNTRANSFER    => true,
        CURLOPT_HEADER            => false,
        CURLOPT_HTTPHEADER        => array(
            "Authorization: Bearer " . $payment['apikey']
        ),
        CURLOPT_FAILONERROR       => false
    ));
    $response = curl_exec($curl);
    $data = json_decode($response, true);
    $datapembayaran = $data['data'];
    curl_close($curl);
    return $datapembayaran;
}
function getmerchantclosed($payment)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_FRESH_CONNECT     => true,
        CURLOPT_URL               => $payment['urlpaymentchannel'],
        CURLOPT_RETURNTRANSFER    => true,
        CURLOPT_HEADER            => false,
        CURLOPT_HTTPHEADER        => array(
            "Authorization: Bearer " . $payment['apikey']
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
            $merchant[] = array('nama' => $dp['name'], 'code' => $dp['code'], 'flat' => $dp['total_fee']['flat'], 'percent' => $dp['total_fee']['percent']);
        }
    }
    return $merchant;
}
function getmerchantopen($payment)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_FRESH_CONNECT     => true,
        CURLOPT_URL               => $payment['urlpaymentchannel'],
        CURLOPT_RETURNTRANSFER    => true,
        CURLOPT_HEADER            => false,
        CURLOPT_HTTPHEADER        => array(
            "Authorization: Bearer " . $payment['apikey']
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
            $merchant[] = array('nama' => $dp['name'], 'code' => $dp['code'], 'flat' => $dp['total_fee']['flat'], 'percent' => $dp['total_fee']['percent']);
        }
    }
    return $merchant;
}
function paymentkalkulator($payment,$channel, $saldo)
{
    $payload = [
        'code'    => $channel,
        'amount'    => $saldo
    ];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_FRESH_CONNECT     => true,
        CURLOPT_URL               => $payment['urlfeekalkulator'] . http_build_query($payload),
        CURLOPT_RETURNTRANSFER    => true,
        CURLOPT_HEADER            => false,
        CURLOPT_HTTPHEADER        => array(
            "Authorization: Bearer " . $payment['apikey']
        ),
        CURLOPT_FAILONERROR       => false
    ));

    $response = curl_exec($curl);
    $data = json_decode($response, true);

    curl_close($curl);
    return $data['data'][0]['total_fee'];
}

function createtransaction($payment,$dataitem, $order_number, $channel, $totalbayar, $phone)
{
    $data = [
        'method'            => $channel,
        'merchant_ref'      => $order_number,
        'amount'            => $totalbayar,
        'customer_name'     => user()->fullname,
        'customer_email'    => user()->email,
        'customer_phone'    => $phone,
        'order_items'       => $dataitem,
        'callback_url'      => base_url().'/'.$payment['callback'],
        'return_url'        => base_url('user/invoice'),
        'expired_time'      => (time() + (24 * 60 * 60)), // 24 jam
        'signature'         => hash_hmac('sha256', $payment['kodemerchant'] . $order_number . $totalbayar, $payment['apiprivatekey'])
    ];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_FRESH_CONNECT     => true,
        CURLOPT_URL               => $payment['urlcreatepayment'],
        CURLOPT_RETURNTRANSFER    => true,
        CURLOPT_HEADER            => false,
        CURLOPT_HTTPHEADER        => array(
            "Authorization: Bearer " . $payment['apikey']
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

function detailtransaksi($payment,$referensi)
{
    $payload = [
        'reference'    => $referensi
    ];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_FRESH_CONNECT     => true,
        CURLOPT_URL               => $payment['detailtransaksiurl'] . http_build_query($payload),
        CURLOPT_RETURNTRANSFER    => true,
        CURLOPT_HEADER            => false,
        CURLOPT_HTTPHEADER        => array(
            "Authorization: Bearer " . $payment['apikey']
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