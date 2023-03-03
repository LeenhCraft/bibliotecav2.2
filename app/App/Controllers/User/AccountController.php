<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class AccountController extends Controller
{

    public function __construct()
    {
        // echo "construct account";
    }

    public function index($request, $response, $args)
    {
        $response->getBody()->write("perfil");
        return $response;
    }

    public function account($request, $response, $args)
    {
        $response->getBody()->write("account");
        return $response;
    }

    public function edit($request, $response, $args)
    {
        $response->getBody()->write("edit");
        return $response;
    }
}
