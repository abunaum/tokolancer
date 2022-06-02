<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Dataawal extends Seeder
{
	public function run()
	{
		$dataapi = [
			'apikey' => 'DEV-hIvWW2APKrWpEO68PXC4LWKhU3h4oBui23eJNJIr',
			'apiprivatekey'    => 'qLlfi-VMwzL-nXVl0-bFPpa-bt6YS',
			'urlpaymentchannel' => 'https://payment.tripay.co.id/api-sandbox/merchant/payment-channel',
			'urlfeekalkulator' => 'https://payment.tripay.co.id/api-sandbox/merchant/fee-calculator?',
			'urlcreatepayment' => 'https://payment.tripay.co.id/api-sandbox/transaction/create',
			'urldetailtransaksi' => 'https://payment.tripay.co.id/api-sandbox/transaction/detail?',
			'kodemerchant' => 'T1438',
			'callback' => 'api/proses/gasspol/mantap/callback',
			'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
			'updated_at' => Time::now('Asia/Jakarta', 'id_ID')
		];
		$this->db->table('apipayment')->insert($dataapi);

		$data_item = [
			[
				'nama' => 'Akun',
				'status'    => 1,
				'sub'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'nama' => 'Top Up',
				'status'    => 1,
				'sub'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'nama' => 'Voucher',
				'status'    => 1,
				'sub'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'nama' => 'Aplikasi',
				'status'    => 1,
				'sub'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'nama' => 'Server',
				'status'    => 1,
				'sub'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'nama' => 'Source Code',
				'status'    => 1,
				'sub'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'nama' => 'Utilitas',
				'status'    => 1,
				'sub'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID')
			]
		];
		$this->db->table('item')->insertBatch($data_item);

		$data_sub_item = [
			[
				'item' => 1,
				'nama' => 'Adsense',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 1,
				'nama' => 'Google Ads',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 2,
				'nama' => 'Ovo',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 2,
				'nama' => 'Dana',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 2,
				'nama' => 'Gopay',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 2,
				'nama' => 'Shopee Pay',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 2,
				'nama' => 'Link Aja',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 2,
				'nama' => 'Paypal',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 3,
				'nama' => 'Google Play',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 3,
				'nama' => 'Garena Shell',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 3,
				'nama' => 'Amazon Gift',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 4,
				'nama' => 'Ms. Office',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 4,
				'nama' => 'Antivirus',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 5,
				'nama' => 'Hosting',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 5,
				'nama' => 'RDP / VPS',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 5,
				'nama' => 'WHM',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 5,
				'nama' => 'Domain',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 6,
				'nama' => 'Codeigniter',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 6,
				'nama' => 'Laravel',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 6,
				'nama' => 'Node Js',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 6,
				'nama' => 'Django',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 6,
				'nama' => 'PHP Native',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 7,
				'nama' => 'Pulsa',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID'),
			],
			[
				'item' => 7,
				'nama' => 'Paket Data',
				'status'    => 1,
				'created_at' => Time::now('Asia/Jakarta', 'id_ID'),
				'updated_at' => Time::now('Asia/Jakarta', 'id_ID')
			]
		];
		$this->db->table('sub_item')->insertBatch($data_sub_item);

	}
}
