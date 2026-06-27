<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\OrderController;
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HealthController;
use App\Controllers\LeadController;

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();
check_session_timeout();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'handleLogin']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/health', [HealthController::class, 'index']);
$router->get('/leads', [LeadController::class, 'index']);
$router->get('/leads/create', [LeadController::class, 'create']);
$router->post('/leads', [LeadController::class, 'store']);
$router->get('/leads/edit', [LeadController::class, 'edit']);
$router->post('/leads/update', [LeadController::class, 'update']);
$router->post('/leads/delete', [LeadController::class, 'delete']);
$router->get('/orders', [OrderController::class, 'index']);
$router->get('/orders/create', [OrderController::class, 'create']);
$router->post('/orders', [OrderController::class, 'store']);
$router->get('/orders/edit', [OrderController::class, 'edit']);
$router->post('/orders/update', [OrderController::class, 'update']);
$router->post('/orders/delete', [OrderController::class, 'delete']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);