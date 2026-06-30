<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('role/', 'RoleController::index');
$routes->post('role/create', 'RoleController::create');
