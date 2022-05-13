<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Download extends BaseController
{
    use ResponseTrait;
    public function kartu($id = 0)
    {
        if (logged_in('true')) {
            $iduser = user()->id;
            $role = $this->role->carirole($iduser);
            $roleuser = $role->get()->getFirstRow();
            $roleuser = $roleuser->group_id;
            if ($roleuser != 1) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            } else {
                $lokasi = ROOTPATH . 'img/toko/aktivasi/';
                $toko = $this->toko->where('id', $id)->get()->getFirstRow();
                $kartu = $toko->kartu;
                $usernametoko = $toko->username;
                $file = new \CodeIgniter\Files\File($lokasi . $kartu);
                $fileext = $file->guessExtension();
                return $this->response->download($lokasi . $kartu, null)->setFileName($usernametoko . '-kartu.' . $fileext);
            }
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function selfi($id = 0)
    {
        if (logged_in('true')) {
            $iduser = user()->id;
            $role = $this->role->carirole($iduser);
            $roleuser = $role->get()->getFirstRow();
            $roleuser = $roleuser->group_id;
            if ($roleuser != 1) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            } else {
                $lokasi = ROOTPATH . 'img/toko/aktivasi/';
                $toko = $this->toko->where('id', $id)->get()->getFirstRow();
                $selfi = $toko->selfi;
                $usernametoko = $toko->username;
                $file = new \CodeIgniter\Files\File($lokasi . $selfi);
                $fileext = $file->guessExtension();
                return $this->response->download($lokasi . $selfi, null)->setFileName($usernametoko . '-selfi.' . $fileext);
            }
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    //--------------------------------------------------------------------

}
