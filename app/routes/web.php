<?php

// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;


use App\Controllers\HomeController;
use App\Controllers\Login\LoginController;
use App\Controllers\Login\RegisterController;
use App\Controllers\Login\verifyController;
use App\Controllers\LogoutController;
use App\Controllers\User\AccountController;
use App\Controllers\WebController;

$mw = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['lnh'])) {
        return $response
            ->withHeader('Location', base_url() . 'login')
            ->withStatus(302);
    }
    return $response;
};


$lg = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['lnh'])) {
        return $response
            ->withHeader('Location', base_url() . 'me')
            ->withStatus(302);
    }
    return $response;
};

$app->get('/', WebController::class . ':index');
$app->get('/login', LoginController::class . ':index')->add($lg);
$app->post('/login', LoginController::class . ':login');
$app->get('/register', RegisterController::class . ':index')->add($lg);
$app->post('/register', RegisterController::class . ':save');
$app->get('/verify-email/{url}', verifyController::class . ':index');
$app->post('/email/verification-notification', verifyController::class . ':notification');
$app->get('/logout', LogoutController::class . ':index');

$app->get('/dni[/{dni}]', HomeController::class . ':dni');

$app->get('/email', RegisterController::class . ':sendEmail');


$app->group('/me', function (RouteCollectorProxy $group) {
    $group->get("", AccountController::class . ':index');
    $group->get("/account", AccountController::class . ':account');
    $group->get("/my-books", AccountController::class . ':edit');
})->add($mw);
