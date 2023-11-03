<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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
$routes->get('login', '');
$routes->get('auth/login', 'Auth/Login::index');
$routes->get('auth/logout', 'Auth/Login::logout');
$routes->get('/auth/administrator/dashboard', 'Auth/Administrator::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/users', 'Auth/User::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/budget', 'Auth/Budget::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/pemasukan/kategori', 'Auth/Kategoridonasi::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/pengeluaran/kategori', 'Auth/Kategorikeluar::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/pemasukan/sub-kategori', 'Auth/Subkategoridonasi::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/pengeluaran/sub-kategori', 'Auth/Subkategorikeluar::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/pemasukan/donasi', 'Auth/Donasi::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/pengeluaran/pengeluaran', 'Auth/Pengeluaran::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/blog/kategori', 'Auth/Kategoriartikel::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/blog/artikel', 'Auth/Artikel::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/blog/materi', 'Auth/Materi::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/blog/video', 'Auth/Video::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/kajian', 'Auth/Kajian::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/setting', 'Auth/Setting::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/profile', 'Auth/Profile::index', ['filter' => 'ceklogin']);
$routes->get('/auth/administrator/bank', 'Auth/Bank::index', ['filter' => 'ceklogin']);

$routes->get('/artikel/read/(:segment)', 'Home::read/$1');
$routes->get('/profile', 'Home::profile');
$routes->get('/kajian', 'Home::kajian');
$routes->get('/video', 'Home::video');
$routes->get('/download', 'Home::download');
$routes->get('/download(:any)', 'Home::unduh');
$routes->get('/contact', 'Home::contact');
$routes->get('/artikel', 'Home::artikel');
$routes->get('/artikel/kategori/(:segment)', 'Home::kategoriartikel/$1');
$routes->get('/kajian/kategori/(:segment)', 'Home::kategorikajian/$1');
$routes->get('/video/kategori/(:segment)', 'Home::kategorivideo/$1');
$routes->get('/donasi', 'Home::donasi');
$routes->get('/donasi/(:segment)', 'Home::donasi_spesifik/$1');
$routes->get('/donasi/validation/(:segment)', 'Home::validasi_donasi/$1');
$routes->get('/konfirmasi-donasi', 'Home::konfirmasidonasi');
$routes->get('/konfirmasi-donasi/kode=(:segment)', 'Home::getformkonfirmasi/$1');
$routes->get('/donasi/validation/download/kode=(:segment)', 'Home::invoice/$1');

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
