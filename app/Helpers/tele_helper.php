<?php
function kirimpesan($chatId, $pesan)
{
    $token = '1626928610:AAEqV2Nu-6N7TXZJ5H-aagaXMDdvjhfX4O0';
    $pesan1 = urlencode($pesan);
    $pesan2 = str_replace('%5Cn', ' %0A', $pesan1);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.telegram.org/bot$token/sendMessage",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "chat_id=$chatId&text=$pesan2",
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));
    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);
    if ($response['ok'] == 1) {
        return 'sukses';
    } else {
        return 'gagal';
    }
}
