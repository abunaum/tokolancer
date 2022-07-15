<?php
function datapayment()
{
    $data = file_get_contents(ROOTPATH . "config.json");
    $config = json_decode($data, TRUE);
    $data = $config['payment'];
    return $data;
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