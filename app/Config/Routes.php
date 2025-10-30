<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', function($routes) {
    $routes->post('login', 'Api\Auth::login');
    $routes->post('login/confirm-otp', 'Api\Auth::login_otp');

    $routes->group('', ['filter' => 'auth'], function($routes) {
        $routes->get('user', 'Api\User::index');
        $routes->get('articles', 'Api\Article::index');
        $routes->get('vouchers', 'Api\Voucher::index');
        $routes->get('voucher/(:num)', 'Api\Voucher::get_by_id/$1');
    });
});

$routes->group('utilities', function($routes) {
    // $routes->get('clear-expired-cache', 'Api\Utilities\Cache::clear_cache');
    // $routes->group('', ['filter' => 'auth-utilities'], function($routes) {        
    // });
});



/*
Admin Panel
*/
$routes->group('admin', function($routes) {
    $routes->get('login', 'Admin\Login::login');
});
