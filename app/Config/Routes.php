<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/register', 'AuthController::register');
$routes->post('/store', 'AuthController::store');
$routes->get('/login', 'AuthController::login');
$routes->post('/authenticate', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/testdb', 'AuthController::testDB');
$routes->get('/chat', 'ChatController::index');
$routes->get('/logout', 'AuthController::logout');
$routes->get('test-redis', 'ChatController::testRedis');
$routes->post('chat/sendMessage', 'ChatController::sendMessage');
$routes->get('chat/retrieveMessages', 'ChatController::retrieveMessages');



