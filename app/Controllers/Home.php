<?php

namespace App\Controllers;

use App\Libraries\Itemlibrary;

class Home extends BaseController
{
    public function __construct()
    {
        $this->getitem = new Itemlibrary();
    }
    public function index()
    {
        $cari = $this->request->getVar('search');
        $produk = $this->produk;
        $produk->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $produk->join('users', 'users.id = produk.owner', 'LEFT');
        $produk->select('produk.*');
        $produk->select('toko.username');
        $produk->select('users.status_toko');
        $produk->select('toko.status');
        $produk->where('status_toko', 4);
        $produk->where('stok >=', 1);

        $item = getsub();
        if ($cari) {
            $produk = $this->produk->search($cari);
        }
        $data = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item,
            'produk' => $produk->paginate(4),
            'pager' => $produk->pager,
        ];

        return view('halaman/beranda', $data);
    }

    public function produkdetail($id)
    {
        $produk = $this->produk->where('id', $id)->get()->getFirstRow();
        $item = $this->getitem->getsub();
        $toko = $this->toko->where('userid', $produk->owner)->get()->getFirstRow();
        $produktoko = $this->produk->where('owner', $produk->owner);
        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item,
            'toko' => $toko,
            'validation' => \Config\Services::validation(),
            'produk' => $produk,
            'produktoko' => $produktoko->paginate(6),
            'pager' => $produktoko->pager,
        ];
        return view('halaman/produkdetail', $data);
    }
}
