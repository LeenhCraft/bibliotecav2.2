<?php

use App\Controllers\HomeController;

$app->get('/admin/login', HomeController::class . ':index');
