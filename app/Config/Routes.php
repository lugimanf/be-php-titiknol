<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', function($routes) {
    $routes->post('login', 'Api\Auth::login');
    $routes->post('login/confirm-otp', 'Api\Auth::login_otp');

    $routes->group('', ['filter' => 'auth'], function($routes) {
        //user
        $routes->get('user', 'Api\User::index');
        $routes->patch('user/fcm-token', 'Api\User::patch_fcm_token');
        //articles
        $routes->get('articles', 'Api\Article::index');
        //vouchers
        $routes->get('vouchers', 'Api\Voucher::index');        
        $routes->get('voucher/(:num)', 'Api\Voucher::get_by_id/$1');
        //voucher's user
        $routes->post('user/voucher', 'Api\UserVoucher::insert_voucher');
        $routes->get('user/vouchers', 'Api\UserVoucher::user_voucher');
        $routes->get('user/voucher/(:num)', 'Api\Voucher::get_by_id/$1');
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
