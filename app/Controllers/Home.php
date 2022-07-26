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
        $produk->join('sub_item', 'sub_item.id = produk.jenis', 'LEFT');
        $produk->join('users', 'users.id = produk.owner', 'LEFT');
        $produk->select('produk.*');
        $produk->select('sub_item.id as id_jenis');
        $produk->select('sub_item.nama as jenis');
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
            'produk' => $produk->paginate(4,'halaman'),
            'pager' => $produk->pager,
        ];

        return view('halaman/beranda', $data);
    }

    public function jenis($id = 0)
    {
        $cari = $this->request->getVar('search');
        $produk = $this->produk;
        $produk->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $produk->join('sub_item', 'sub_item.id = produk.jenis', 'LEFT');
        $produk->join('users', 'users.id = produk.owner', 'LEFT');
        $produk->select('produk.*');
        $produk->select('sub_item.id as id_jenis');
        $produk->select('sub_item.nama as jenis');
        $produk->select('toko.username');
        $produk->select('users.status_toko');
        $produk->select('toko.status');
        $produk->where('sub_item.id', $id);
        $produk->where('status_toko', 4);
        $produk->where('stok >=', 1);
        $item = getsub();
        if ($cari) {
            $produk = $this->produk->search($cari);
        }
        $data = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item,
            'produk' => $produk->paginate(4,'halaman'),
            'pager' => $produk->pager,
        ];

        return view('halaman/beranda', $data);
    }

    public function produkdetail($id)
    {
        $produk = $this->produk;
        $produk->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $produk->join('sub_item', 'sub_item.id = produk.jenis', 'LEFT');
        $produk->select('produk.*');
        $produk->select('toko.status as status_toko');
        $produk->select('toko.username as username_toko');
        $produk->select('sub_item.id as id_jenis');
        $produk->select('sub_item.nama as jenis');
        $produk = $produk->where('produk.id', $id)->first();
        if (!$produk){
            session()->setFlashdata('error', 'Produk tidak ditemukan');
            return redirect()->to(base_url());
        }

        $terjual = $this->keranjang;
        $terjual->where('produk', $id);
        $terjual->where('status', 6);
        $terjual = $terjual->findAll();
        $terjual = count($terjual);

        $item = $this->getitem->getsub();
        $produktoko = $this->produk;
        $produktoko->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $produktoko->join('sub_item', 'sub_item.id = produk.jenis', 'LEFT');
        $produktoko->where('owner', $produk['owner']);
        $produktoko->select('produk.*');
        $produktoko->select('toko.status as status_toko');
        $produktoko->select('toko.username as username_toko');
        $produktoko->select('sub_item.id as id_jenis');
        $produktoko->select('sub_item.nama as jenis');
        $produktoko->where('owner', $produk['owner']);
        $produktoko->where('toko.status', 1);
        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item,
            'validation' => \Config\Services::validation(),
            'produk' => (object)$produk,
            'terjual' => $terjual,
            'produktoko' => $produktoko->paginate(6),
            'pager' => $produktoko->pager,
        ];
        return view('halaman/produkdetail', $data);
    }
}
