<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('jenis/(:num)', 'Home::jenis/$1');
$routes->get('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->group('auth', function ($routes) {
    $routes->get('cek', 'Auth::cek');
});

$routes->post('console/callback', 'Callback::callback');

$routes->get('produk/detail/(:num)', 'Home::produkdetail/$1');
$routes->group('admin',["filter" => "auth"], function ($routes) {
    $routes->get('', 'Admin\Admin::index');
    $routes->get('notifikasi', 'Admin\Admin::notifikasi');
    $routes->post('notifikasi', 'Admin\Admin::tambahtele');
    $routes->post('ubahtele', 'Admin\Admin::ubahtele');
    $routes->get('teleulang', 'Admin\Admin::telelagi');
    $routes->post('veriftele', 'Admin\Admin::veriftele');
    $routes->group('download', function ($routes) {
        $routes->post('kartu/(:num)', 'Admin\Download::kartu/$1');
        $routes->post('selfi/(:num)', 'Admin\Download::selfi/$1');
    });
    $routes->group('item', function ($routes) {
        $routes->get('', 'Admin\Admin::item');
        $routes->post('add_item', 'Admin\Admin::item_tambah_prosess');
        $routes->delete('hapus/(:num)', 'Admin\Admin::item_hapus/$1');
        $routes->post('nonaktifkan/(:num)', 'Admin\Admin::item_nonaktifkan/$1');
        $routes->post('aktifkan/(:num)', 'Admin\Admin::item_aktifkan/$1');
        $routes->post('subitem/nonaktifkan/(:num)', 'Admin\Admin::item_subitem_nonaktifkan/$1');
        $routes->post('subitem/aktifkan/(:num)', 'Admin\Admin::item_subitem_aktifkan/$1');
    });
    $routes->group('subitem', function ($routes) {
        $routes->get('', 'Admin\Admin::subitem');
        $routes->post('add_item', 'Admin\Admin::subitem_tambah_prosess');
        $routes->post('nonaktifkan/(:num)', 'Admin\Admin::subitem_nonaktifkan/$1');
        $routes->post('aktifkan/(:num)', 'Admin\Admin::subitem_aktifkan/$1');
        $routes->delete('hapus/(:num)', 'Admin\Admin::subitem_hapus/$1');
    });
    $routes->group('user', function ($routes) {
        $routes->get('', 'Admin\User::index');
        $routes->post('disable/(:num)', 'Admin\User::disable/$1');
        $routes->post('enable/(:num)', 'Admin\User::enable/$1');
    });
    $routes->group('toko', function ($routes) {
        $routes->get('pengajuan', 'Admin\Toko::pengajuan');
        $routes->post('detail/(:num)', 'Admin\Toko::pengajuandetail/$1');
        $routes->post('tolak/(:num)', 'Admin\Toko::pengajuantolak/$1');
        $routes->post('acc/(:num)', 'Admin\Toko::pengajuanacc/$1');
        $routes->get('toko', 'Admin\Toko::listtoko');
        $routes->post('banned/(:num)', 'Admin\Toko::banned/$1');
        $routes->post('unbanned/(:num)', 'Admin\Toko::unbanned/$1');
        $routes->get('produk', 'Admin\Toko::listproduk');
        $routes->delete('hapusproduk/(:num)', 'Admin\Toko::hapusproduk/$1');
    });
    $routes->group('pencairan', function ($routes) {
        $routes->get('seller', 'Admin\Toko::pencairan_seller');
        $routes->post('acc/(:num)', 'Admin\Toko::pencairanacc/$1');
        $routes->post('tolak/(:num)', 'Admin\Toko::pencairantolak/$1');
        $routes->get('riwayat', 'Admin\Toko::riwayat_pencairan');
    });
    $routes->group('transaksi', function ($routes) {
        $routes->get('berlangsung', 'Admin\Transaksi::berlangsung');
        $routes->post('batalkan/(:num)', 'Admin\Transaksi::batalkan/$1');
        $routes->post('konfirmasi/(:num)', 'Admin\Transaksi::konfirmasi/$1');
        $routes->get('selesai', 'Admin\Transaksi::selesai');
        $routes->get('bermasalah', 'Admin\Transaksi::bermasalah');
        $routes->post('refund/(:num)', 'Admin\Transaksi::refund/$1');
    });
});
$routes->group('toko', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'Toko\Fitur::index');
    $routes->post('buattoko', 'Toko\Fitur::buat_toko');
    $routes->post('edittoko', 'Toko\Fitur::edittoko');
    $routes->post('aktivasitoko', 'Toko\Fitur::aktivasi');
});

$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('notifikasi', 'User\notifikasi::index');
    $routes->post('notifikasi', 'User\notifikasi::pasangtele');
    $routes->get('notifikasi/kirimteleulang', 'User\notifikasi::teleulang');
    $routes->post('notifikasi/ubahtele', 'User\notifikasi::ubahtele');
    $routes->post('notifikasi/veriftele', 'User\notifikasi::veriftele');
    $routes->get('profile', 'User\profile::index');
    $routes->post('ubahdata', 'User\profile::ubahdata');
    $routes->post('ubahpassword', 'User\profile::ubahpassword');
    $routes->get('saldo', 'User\saldo::index');
    $routes->post('tambahsaldo', 'User\saldo::tambah');
    $routes->get('saldo/topup', 'User\saldo::topup');
    $routes->post('topup/prosess/(:num)', 'User\saldo::topupproses/$1');
    $routes->get('topup/prosess/(:num)', 'User\saldo::topupproses/$1');
    $routes->post('topup/ulangprosess/(:num)', 'User\saldo::ulangtopupproses/$1');
    $routes->get('topup/ulangprosess/(:num)', 'User\saldo::ulangtopupproses/$1');
    $routes->delete('transaksisaldo/hapus/(:num)', 'User\saldo::transaksihapus/$1');
    $routes->group('toko', function ($routes) {
        $routes->get('produk', 'User\toko::produk');
        $routes->get('pengaturan', 'User\toko::pengaturan');
        $routes->get('produk/detail/(:num)', 'User\toko::produkdetail/$1');
        $routes->delete('produk/hapus/(:num)', 'User\toko::hapusproduk/$1');
        $routes->post('produk/edit/(:num)', 'User\toko::editproduk/$1');
        $routes->get('tambah', 'User\toko::tambah');
        $routes->post('tambahproduk', 'User\toko::tambahproduk');
        $routes->get('transaksi', 'User\toko::transaksi');
        $routes->delete('batalkan/(:num)', 'User\toko::batalkanpesanan/$1');
        $routes->post('kirim/(:num)', 'User\toko::kirimproduk/$1');
        $routes->get('saldo', 'User\toko::saldo');
        $routes->post('cairkan', 'User\toko::cairkan');
        $routes->get('riwayat_pencairan', 'User\toko::riwayat_pencairan');
    });
    $routes->group('order', function ($routes) {
        $routes->post('produk/(:num)', 'User\order::produk/$1');
        $routes->get('keranjang', 'User\order::keranjang');
        $routes->get('transaksi', 'User\order::transaksi');
        $routes->post('bayar/(:num)', 'User\order::bayar/$1');
        $routes->delete('semuakeranjang', 'User\order::hapussemuakeranjang');
        $routes->delete('keranjang/(:num)', 'User\order::hapuskeranjang/$1');
        $routes->delete('invoice/(:num)', 'User\order::hapusinvoice/$1');
        $routes->post('proses', 'User\order::proseskeranjang');
        $routes->post('edit/(:num)', 'User\order::editkeranjang/$1');
        $routes->delete('deletetransaksi/(:num)', 'User\order::hapustransaksi/$1');
        $routes->delete('canceltransaksi/(:num)', 'User\order::canceltransaksi/$1');
        $routes->get('detailtransaksi/(:num)', 'User\order::detailtransaksi/$1');
        $routes->post('updatetransaksi/(:num)', 'User\order::updatetransaksi/$1');
        $routes->post('transaksiselesai/(:num)', 'User\order::transaksiselesai/$1');
        $routes->post('transaksibermasalah/(:num)', 'User\order::transaksibermasalah/$1');
    });
    $routes->group('keranjang', function ($routes) {
        $routes->get('produk/(:num)', 'User\order::tambahkeranjang/$1');
    });
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
