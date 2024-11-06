<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/produk', 'Produk::index');
$routes->post('/produk/simpan', 'Produk::simpan_produk');
$routes->get('/produk/tampil', 'Produk::tampil_produk');
$routes->get('/produk/tampil/(:num)', 'Produk::tampil_by_id/$1');  // Route for fetching product by ID
$routes->post('/produk/update', 'Produk::update');  // Route for updating product
$routes->delete('/produk/hapus/(:num)', 'Produk::hapus_produk/$1');
