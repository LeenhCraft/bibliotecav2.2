<?php

namespace App\Controllers;

class LogoutController extends Controller
{
    public function index($request, $response, $args)
    {
        session_unset();
        session_destroy();
        return $response
            ->withHeader('Location', base_url())
            ->withStatus(302);
    }
}
