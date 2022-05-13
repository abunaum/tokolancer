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
$routes->get('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->group('auth', function ($routes) {
    $routes->get('cek', 'Auth::cek');
});
$routes->group('admin', function ($routes) {
    $routes->get('', 'Admin\Admin::index');
    $routes->get('profile', 'Admin\Admin::profile');
    $routes->get('notifikasi', 'Admin\Admin::notifikasi');
    $routes->post('notifikasi', 'Admin\Admin::tambahtele');
    $routes->post('ubahtele', 'Admin\Admin::ubahtele');
    $routes->get('teleulang', 'Admin\Admin::telelagi');
    $routes->post('veriftele', 'Admin\Admin::veriftele');
    $routes->post('ubahpassword', 'Admin\Admin::ubahpassword');
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
        $routes->post('(:num)', 'Admin\User::detail/$1');
    });
    $routes->group('toko', function ($routes) {
        $routes->get('pengajuan', 'Admin\Toko::pengajuan');
        $routes->post('detail/(:num)', 'Admin\Toko::pengajuandetail/$1');
        $routes->post('tolak/(:num)', 'Admin\Toko::pengajuantolak/$1');
        $routes->post('acc/(:num)', 'Admin\Toko::pengajuanacc/$1');
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
