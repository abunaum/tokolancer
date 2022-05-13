<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiPaymentModel extends Model
{
    protected $table = 'apipayment';
    protected $useTimestamps = true;
    protected $allowedFields = ['apikey', 'apiprivatekey', 'urlpaymentchannel', 'urlfeekalkulator', 'urlcreatepayment', 'kodemerchant', 'callback'];

    public function get()
    {
        $api = $this->table('apipayment');
        $api->where('id', 1)->get()->getFirstRow();;
        return $api;
    }
}
