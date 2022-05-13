<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';

    protected $allowedFields = ['jenis', 'nama', 'owner', 'gambar', 'harga', 'keterangan', 'slug', 'stok'];

    public function search($cari)
    {
        $produk = $this->table('produk');
        $produk->where('stok >=', 1);
        $produk->like('slug', $cari);
        return $produk;
    }

    public function kategori($id)
    {
        $produk = $this->table('produk');
        $produk->where('stok >=', 1);
        $produk->where('jenis', $id);
        return $produk;
    }
    public function detail($id)
    {
        $produk = $this->table('produk');
        $produk->join('toko', 'toko.userid = produk.owner', 'RIGHT');
        $produk->join('users', 'users.id = produk.owner', 'RIGHT');
        $produk->join('sub_item', 'sub_item.id = produk.jenis', 'RIGHT');
        $produk->select('produk.*');
        $produk->select('toko.username as toko_username');
        $produk->select('toko.status as toko_status');
        $produk->select('users.username as user_username');
        $produk->select('sub_item.nama as sub_nama');
        $produk->where('produk.id', $id);
        return $produk;
    }
    public function produktoko($owner)
    {
        $produk = $this->table('produk');
        $produk->where('stok>=', 1);
        $produk->where('owner', $owner);
        return $produk;
    }
}
