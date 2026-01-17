<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas Censo
$routes->get('censo', 'CensoController::index');
$routes->post('censo/guardar', 'CensoController::guardar');

// Rutas Precios
$routes->post('precios/actualizar', 'PrecioController::establecerPrecios');

// Rutas Gas
$routes->get('gas/nuevo', 'GasController::nuevaJornada');
$routes->post('gas/guardar', 'GasController::guardarJornada');


// Rutas Gestión de Líderes
$routes->get('lideres', 'LiderController::index');
$routes->post('lideres/guardar', 'LiderController::guardar');
$routes->post('lideres/actualizar/(:num)', 'LiderController::actualizar/$1');

// Ruta para procesar el login
$routes->post('auth/login', 'AuthController::login');
$routes->get('salir', 'AuthController::salir');

// Grupo de rutas PROTEGIDAS (Solo entra Maritza)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('inicio', 'Home::index'); // La página de bienvenida
    $routes->get('principal', 'Home::principal'); // La página del mapa/comunidad
    $routes->get('censo', 'CensoController::index');
    $routes->get('gas', 'GasController::procesarJornada');
    // ... agrega aquí todas las rutas que quieres proteger
});