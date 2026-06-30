<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UsersController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('users/validate', 'UsersController::validateAjax');
$routes->get('/inscription', 'UsersController::inscription');
$routes->get('role/', 'RoleController::index');
$routes->post('role/create', 'RoleController::create');
$routes->get('users/login', 'UsersController::login');
$routes->post('users/login', 'UsersController::loginPost');



$routes->group('admin', ['filter' => 'auth:1'], function($routes) {
    $routes->get('dashboard', 'AdminController::index');
});
$routes->group('rh', ['filter' => 'auth:2'], function($routes) {
    $routes->get('dashboard', 'RhController::index');
});
$routes->group('user', ['filter' => 'auth:3'], function($routes) {
    $routes->get('dashboard', 'UserController::index');
});