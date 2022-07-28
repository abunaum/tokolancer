<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Setting extends BaseController
{
    public function index()
    {
        $config = ambilconfig();
        $merchant = explode("/", $config['payment']['urlcreatepayment']);
        if ($merchant[3] == 'api-sandbox') {
            $merchant = 'Sandbox';
        } else {
            $merchant = 'Real Merchant';
        }
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Setting | $this->namaweb",
            'config' => $config,
            'merchant' => $merchant,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/setting', $data);
    }

    public function gauth()
    {
        if (!$this->validate([
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID harus di isi'
                ]
            ],
            'secret' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Secret Key harus di isi'
                ]
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal edit Gauth');
            return redirect()->to(base_url('admin/setting'))->withInput();
        }
        $config = ambilconfig();
        $config['gauth']['id'] = $this->request->getVar('id');
        $config['gauth']['secret'] = $this->request->getVar('secret');
        $newconfig = json_encode($config,true);
        file_put_contents(ROOTPATH . 'config.json', $newconfig);
        session()->setFlashdata('pesan', 'berhasil edit Gauth');
        return redirect()->to(base_url('admin/setting'));
    }

    public function payment()
    {
        if (!$this->validate([
            'apikey' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'API Key harus di isi'
                ]
            ],
            'apiprivatekey' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'API Private Key harus di isi'
                ]
            ],
            'kodemerchant' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode Merchant harus di isi'
                ]
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal edit Payment');
            return redirect()->to(base_url('admin/setting'))->withInput();
        }
        $merchant = $this->request->getVar('merchant');
        $urlpaymentchannel = "https://payment.tripay.co.id/$merchant/merchant/payment-channel";
        $urlfeekalkulator = "https://payment.tripay.co.id/$merchant/merchant/fee-calculator?";
        $urlcreatepayment = "https://payment.tripay.co.id/$merchant/transaction/create";
        $urldetailtransaksi = "https://payment.tripay.co.id/$merchant/transaction/detail?";

        $config = ambilconfig();
        $config['payment']['apikey'] = $this->request->getVar('apikey');
        $config['payment']['apiprivatekey'] = $this->request->getVar('apiprivatekey');
        $config['payment']['urlpaymentchannel'] = $urlpaymentchannel;
        $config['payment']['urlfeekalkulator'] = $urlfeekalkulator;
        $config['payment']['urlcreatepayment'] = $urlcreatepayment;
        $config['payment']['urldetailtransaksi'] = $urldetailtransaksi;
        $config['payment']['kodemerchant'] = $this->request->getVar('kodemerchant');
        $newconfig = json_encode($config,true);
        file_put_contents(ROOTPATH . 'config.json', $newconfig);
        session()->setFlashdata('pesan', 'berhasil edit Payment');
        return redirect()->to(base_url('admin/setting'));
    }

    public function penghasilan()
    {

        if (!$this->validate([
            'feemc' => [
                'rules' => 'required|is_natural_no_zero|less_than_equal_to[100]',
                'errors' => [
                    'required' => 'Fee transaksi harus di isi',
                    'is_natural_no_zero' => 'Fee transaksi tidak valid',
                    'less_than_equal_to' => 'Maksimal fee transaksi hanya 100'
                ]
            ],
            'minimal' => [
                'rules' => 'required|is_natural_no_zero|greater_than_equal_to[10000]',
                'errors' => [
                    'required' => 'Minimal Pencairan harus di isi',
                    'is_natural_no_zero' => 'Minimal Pencairan tidak valid',
                    'greater_than_equal_to' => 'Minimal Pencairan adalah 10000'
                ]
            ],
            'fee' => [
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Fee Pencairan harus di isi',
                    'is_natural_no_zero' => 'Fee Pencairan tidak valid'
                ]
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal edit Gauth');
            return redirect()->to(base_url('admin/setting'))->withInput();
        }
        $config = ambilconfig();
        $config['feemc']['percent'] = $this->request->getVar('feemc');
        $config['cair']['minimal'] = $this->request->getVar('minimal');
        $config['cair']['fee'] = $this->request->getVar('fee');
        $newconfig = json_encode($config,true);
        file_put_contents(ROOTPATH . 'config.json', $newconfig);
        session()->setFlashdata('pesan', 'berhasil edit penghasilan');
        return redirect()->to(base_url('admin/setting'));
    }
}
