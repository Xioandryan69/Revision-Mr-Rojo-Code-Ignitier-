<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UsersController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('users/validate', 'UsersController::validateAjax');
$routes->get('/inscription', 'UsersController::inscription');