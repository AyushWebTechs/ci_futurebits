<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Levels::index');

$routes->get('levels', 'Levels::index');
$routes->post('levels/store', 'Levels::store');
$routes->post('levels/update/(:num)', 'Levels::update/$1');
$routes->post('levels/delete/(:num)', 'Levels::delete/$1');

$routes->get('agents', 'Agents::index');
$routes->get('agents/history/(:num)', 'Agents::history/$1');
$routes->post('agents/addPoints/(:num)', 'Agents::addPoints/$1');


