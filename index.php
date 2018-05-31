<?php
use App\Models\Task;
use Doctrine\DBAL\Types\Type;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

error_reporting(E_ALL);
require __DIR__.'/bootstrap.php';

$router = new RouteCollector();
$router->get('/', ['App\Controllers\TaskController', 'index']);
$router->post('/create', ['App\Controllers\TaskController', 'create']);
$router->post('/edit', ['App\Controllers\TaskController', 'edit']);
$router->get('/login', ['App\Controllers\AdminController', 'showLoginForm']);
$router->post('/login', ['App\Controllers\AdminController', 'login']);
$router->get('/logout', ['App\Controllers\AdminController', 'logout']);
$dispacher = new Dispatcher($router->getData());
try {
    $response = $dispacher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (\Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    $response = $e->getMessage();
} catch (Exception $e) {
    $response = $e->getMessage();
}

echo $response;