<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\Itemlibrary;
use App\Libraries\PaymentApiLibrary;

class saldo extends BaseController
{
    public $apilib;

    public function __construct()
    {
        $this->apilib = new PaymentApiLibrary();
        $this->getitem = new Itemlibrary();
    }

    public function index()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'judul' => "Saldo | $this->namaweb",
            'item' => $item,
            'toko' => $toko->where('userid', user()->id)->findAll(),
            'user' => $user,
            'paymentapi' => $this->apilib,
            'validation' => \Config\Services::validation(),
        ];

        return view('halaman/user/saldo', $data);
    }

    public function tambah()
    {
        $saldo = (int) $this->request->getVar('saldo');
        $channel = $this->request->getVar('channel');
        if (!$this->validate([
            'saldo' => 'required',
        ])) {
            session()->setFlashdata('error', 'Gagal menambah saldo, Coba lagi.');

            return redirect()->to(base_url('user/saldo'))->withInput();
        }
        $minimal = 10000;
        if ($saldo < $minimal) {
            session()->setFlashdata('error', 'Gagal menambah saldo, Nominal isi saldo ' . $channel . ' Adalah Rp. ' . number_format($minimal));

            return redirect()->to(base_url('user/saldo'))->withInput();
        }
        $rand = rand(111111, 999999);
        $tgl = date('Ymdhis');
        $order_number = "top-$tgl$rand";
        $nama = 'Topup';
        $totalbayar = $saldo;
        $dataitem = array([
            'sku'       => $nama,
            'name'      => $nama,
            'price'     => $totalbayar,
            'quantity'  => 1
        ]);
        $createpayment = $this->apilib->createtransaction($dataitem, $order_number, $channel, $totalbayar);
        $payment = json_decode($createpayment, true);
        if ($payment['success'] == 1) {
            $this->transaksi_saldo->save([
                'owner' => user()->username,
                'jenis' => 'Topup',
                'order_number' => $order_number,
                'nominal' => $saldo,
                'fee' => $payment['data']['fee'],
                'metode' => $channel,
                'status' => 'pending',
                'reference' => $payment['data']['reference'],
            ]);
            session()->setFlashdata('pesan', 'Mantap, Isi saldo anda telah siap, silahkan selesaikan pembayaran anda');
            return redirect()->to(base_url('user/saldo/topup'));
        } else {
            session()->setFlashdata('error', 'Ooops, Server Error !!');
            return redirect()->to(base_url('user/saldo'));
        }
    }

    public function topup()
    {
        $status = $this->request->getVar('status');
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $transaksi = $this->transaksi_saldo->where('status', 'pending');
        $transaksi = $this->transaksi_saldo->orwhere('status', 'UNPAID');
        $transaksi = $transaksi->where('owner', user()->username)->findAll();
        foreach ($transaksi as $tr) {
            $detailpayment = $this->apilib->detailtransaksi($tr['reference']);
            $detailpayment = json_decode($detailpayment, true);
            $exp = $detailpayment['data']['expired_time'];
            $stt = $detailpayment['data']['status'];
            $time = strtotime("now");
            if ($exp <= $time && $stt != 'PAID') {
                $this->transaksi_saldo->save([
                    'id' => $tr['id'],
                    'status' => 'EXPIRED'
                ]);
            } else {
                $this->transaksi_saldo->save([
                    'id' => $tr['id'],
                    'status' => $detailpayment['data']['status']
                ]);
            }
        }
        $transaksi = $this->transaksi_saldo->where('owner', user()->username)->findAll();
        $group = array();

        foreach ($transaksi as $value) {
            $group[$value['status']][] = $value;
        }
        $trxgroup = [];
        foreach ($group as $type => $labels) {
            $trxgroup[] = [
                'status' => $type,
                $type => $labels,
            ];
        }
        if ($status) {
            $trans = $this->transaksi_saldo->where('reference', $status)->get()->getFirstRow();
            if ($trans) {
                if ($trans->status == 'PAID') {
                    session()->setFlashdata('pesan', 'Mantap, Isi saldo berhasil');
                    return redirect()->to(base_url('user/saldo'));
                }
            }
        }
        if (!$transaksi) {
            return redirect()->to(base_url('user/saldo'));
        }
        $data = [
            'judul' => "Saldo | $this->namaweb",
            'item' => $item,
            'toko' => $toko->where('userid', user()->id)->findAll(),
            'user' => $user,
            'transaksi' => $trxgroup,
            'validation' => \Config\Services::validation(),
        ];

        return view('halaman/user/saldotopup', $data);
    }

    public function topupproses($id = 0)
    {
        $trx = $this->transaksi_saldo->where('id', $id)->get()->getFirstRow();
        if (!$trx) {
            return redirect()->to(base_url('user/saldo'));
        }
        $role = $this->role->where('user_id', user()->id)->get()->getFirstRow();
        if ($role->group_id != 1) {
            if ($trx->owner != user()->username) {
                return redirect()->to(base_url('user/saldo'));
            }
        }
        $referensi = $trx->reference;
        $detailpayment = $this->apilib->detailtransaksi($referensi);
        $detailpayment = json_decode($detailpayment, true);
        if ($detailpayment['data']['status'] == 'PAID') {
            session()->setFlashdata('pesan', 'Mantap, Isi saldo berhasil');
            return redirect()->to(base_url('user/saldo/topup'));
        }
        if ($detailpayment['success'] == 1) {
            $url = $detailpayment['data']['checkout_url'];
            return redirect()->to($url);
        }
    }

    public function ulangtopupproses($id = 0)
    {
        $trx = $this->transaksi_saldo->where('id', $id)->get()->getFirstRow();
        if (!$trx) {
            return redirect()->to(base_url('user/saldo'));
        }
        $role = $this->role->where('user_id', user()->id)->get()->getFirstRow();
        if ($role->group_id != 1) {
            if ($trx->owner != user()->username) {
                return redirect()->to(base_url('user/saldo'));
            }
        }
        $totalbayar = $trx->nominal + $trx->fee;
        $nama = 'Topup';
        $createpayment = $this->apilib->createpayment($nama, $trx->order_number, $trx->metode, $totalbayar);
        $payment = json_decode($createpayment, true);
        if ($payment['success'] == 1) {
            $this->transaksi_saldo->save([
                'id' => $trx->id,
                'status' => 'UNPAID',
                'reference' => $payment['data']['reference'],
            ]);
            session()->setFlashdata('pesan', 'Mantap, ' . $trx->order_number . ' Sudah siap di bayar');
            return redirect()->to(base_url('user/saldo/topup'));
        } else {
            session()->setFlashdata('error', 'Ooops, Server Error !!');

            return redirect()->to(base_url('user/saldo'));
        }
    }

    public function transaksihapus($id = 0)
    {
        $trx = $this->transaksi_saldo->where('id', $id)->get()->getFirstRow();
        if (!$trx) {
            return redirect()->to(base_url('user/saldo'));
        }
        $role = $this->role->where('user_id', user()->id)->get()->getFirstRow();
        if ($role->group_id != 1) {
            if ($trx->owner != user()->username) {
                return redirect()->to(base_url('user/saldo'));
            }
        }
        $this->transaksi_saldo->delete($id);
        session()->setFlashdata('pesan', 'Transaksi Berhasil di hapus');

        return redirect()->to(base_url('user/saldo/topup'));
    }

    //--------------------------------------------------------------------
}
