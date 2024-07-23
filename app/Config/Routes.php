<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', '\App\Controllers\Auth::index');
$routes->post('/login', '\App\Controllers\Auth::login');

$routes->get('/logs', '\App\Controllers\Log::index');
$routes->get('/api/logs', '\App\Controllers\Log::getLogs');

$routes->get('/', '\App\Controllers\Products::index');
$routes->get('/product', '\App\Controllers\Products::getProducts');
$routes->post('/product', '\App\Controllers\Products::createProduct');
$routes->put('/product', '\App\Controllers\Products::updateProduct');
$routes->post('/product-delete', '\App\Controllers\Products::deleteProduct');
