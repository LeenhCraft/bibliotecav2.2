<?php

// use Slim\App;

use App\Controllers\Admin\DashboardController;
use Slim\Routing\RouteCollectorProxy;

// Controllers
use App\Controllers\Admin\LoginAdminController;
use App\Middleware\AdminMiddleware;
// Middlewares
use App\Middleware\LoginAdminMiddleware;

$app->get('/admin/login', LoginAdminController::class . ':index')->add(new AdminMiddleware);
$app->post('/admin/login', LoginAdminController::class . ':sessionUser');
$app->group('/admin', function (RouteCollectorProxy $group) {
    $group->get('', DashboardController::class . ':index');
})->add(new LoginAdminMiddleware());
