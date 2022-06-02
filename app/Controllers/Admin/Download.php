<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Download extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        helper(['role','tele']);
        if (verifadmin() == 'invalid') {
            header("HTTP/1.1 403 Forbidden");
            header("Location: ". base_url());
            exit;
        }
    }
    public function kartu($id = 0)
    {
        if (session('logged_in') != true) {
            return redirect()->to(base_url());
        }
        if (verifadmin() == 'invalid') {
            header("HTTP/1.1 403 Forbidden");
            header("Location: " . base_url());
            exit;
        }
        $lokasi = ROOTPATH . 'img/toko/aktivasi/';
        $toko = $this->toko->where('id', $id)->get()->getFirstRow();
        $kartu = $toko->kartu;
        $usernametoko = $toko->username;
        $file = new \CodeIgniter\Files\File($lokasi . $kartu);
        $fileext = $file->guessExtension();
        return $this->response->download($lokasi . $kartu, null)->setFileName($usernametoko . '-kartu.' . $fileext);

    }

    public function selfi($id = 0)
    {
        if (session('logged_in') != true) {
            return redirect()->to(base_url());
        }
        if (verifadmin() == 'invalid') {
            header("HTTP/1.1 403 Forbidden");
            header("Location: " . base_url());
            exit;
        }
        $lokasi = ROOTPATH . 'img/toko/aktivasi/';
        $toko = $this->toko->where('id', $id)->get()->getFirstRow();
        $selfi = $toko->selfi;
        $usernametoko = $toko->username;
        $file = new \CodeIgniter\Files\File($lokasi . $selfi);
        $fileext = $file->guessExtension();
        return $this->response->download($lokasi . $selfi, null)->setFileName($usernametoko . '-selfi.' . $fileext);
    }

    //--------------------------------------------------------------------

}
