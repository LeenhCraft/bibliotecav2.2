<?php

// use Slim\App;
use App\Controllers\Admin\DashboardController;
use Slim\Routing\RouteCollectorProxy;

// Controllers
use App\Controllers\Admin\LoginAdminController;
use App\Controllers\Admin\MenusController;
use App\Controllers\Admin\PermisosController;
use App\Controllers\Admin\PersonController;
use App\Controllers\Admin\RolController;
use App\Controllers\Admin\SubmenusController;
use App\Controllers\Admin\UserController;
use App\Controllers\LogoutController;
use App\Middleware\AdminMiddleware;

// Middlewares
use App\Middleware\LoginAdminMiddleware;


$app->get('/admin/login', LoginAdminController::class . ':index')->add(new AdminMiddleware);
$app->post('/admin/login', LoginAdminController::class . ':sessionUser');

$app->group('/admin', function (RouteCollectorProxy $group) {
    $group->get("", DashboardController::class . ':index');
    $group->get("/logout", LogoutController::class . ':admin');

    $group->group('/menus', function (RouteCollectorProxy $group) {
        $group->get('', MenusController::class . ':index');
        $group->post('', MenusController::class . ':list');
        $group->post('/save', MenusController::class . ':store');
        $group->post('/update', MenusController::class . ':update');
        $group->post('/search', MenusController::class . ':search');
        $group->post('/delete', MenusController::class . ':delete');
    });


    $group->group('/submenus', function (RouteCollectorProxy $group) {
        $group->get('', SubmenusController::class . ':index');
        $group->post('', SubmenusController::class . ':list');
        $group->post('/save', SubmenusController::class . ':store');
        $group->post('/update', SubmenusController::class . ':update');
        $group->post('/menus', SubmenusController::class . ':menus');
        $group->post('/search', SubmenusController::class . ':search');
        $group->post('/delete', SubmenusController::class . ':delete');
    });

    $group->group('/permisos', function (RouteCollectorProxy $group) {
        $group->get('', PermisosController::class . ':index');
        $group->post('', PermisosController::class . ':list');
        $group->post('/save', PermisosController::class . ':store');
        $group->post('/delete', PermisosController::class . ':delete');
        $group->post('/active', PermisosController::class . ':active');
        $group->post('/roles', PermisosController::class . ':roles');
        $group->post('/submenus', PermisosController::class . ':submenus');
    });

    $group->group('/user', function (RouteCollectorProxy $group) {
        $group->get('', UserController::class . ':index');
        $group->post('/roles', UserController::class . ':roles');
        $group->post('/person', UserController::class . ':person');

        $group->post('', UserController::class . ':list');
        $group->post('/save', UserController::class . ':store');
        $group->post('/search', UserController::class . ':search');
        $group->post('/update', UserController::class . ':update');
        $group->post('/delete', UserController::class . ':delete');
    });

    $group->group('/person', function (RouteCollectorProxy $group) {
        $group->get('', PersonController::class . ':index');

        $group->post('', PersonController::class . ':list');
        $group->post('/save', PersonController::class . ':store');
        $group->post('/search', PersonController::class . ':search');
        $group->post('/update', PersonController::class . ':update');
        $group->post('/delete', PersonController::class . ':delete');
    });

    $group->group('/rol', function (RouteCollectorProxy $group) {
        $group->get('', RolController::class . ':index');

        $group->post('', RolController::class . ':list');
        $group->post('/save', RolController::class . ':store');
        $group->post('/search', RolController::class . ':search');
        $group->post('/update', RolController::class . ':update');
        $group->post('/delete', RolController::class . ':delete');
    });
})->add(new LoginAdminMiddleware());
