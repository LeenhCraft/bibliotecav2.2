<?php

namespace App\Controllers\Login;

use App\Controllers\Controller;
use App\Models\UsuarioModel;

class LoginController extends Controller
{
    public function index($request, $response, $args)
    {
        $return = $this->view("Web.login", [
            "data" => [
                'title' => 'Login',
            ],
            "js" => [
                "js/web/login.js"
            ],
        ]);
        $response->getBody()->write($return);
        return $response;
    }

    public function login($request, $response, $args)
    {

        $data = sanitizar($request->getParsedBody());
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where("usu_usuario", "LIKE", $data["email"])->first();

        if (empty($usuario)) {
            $msg = "El usuario no existe";
            return $this->respondWithError($response, $msg);
        }

        if (!password_verify($data["password"], $usuario["usu_pass"])) {
            $msg = "La contraseña no es valida";
            return $this->respondWithError($response, $msg);
        }

        if ($usuario["usu_estado"] == 0) {
            $msg = "El usuario está desactivado";
            return $this->respondWithError($response, $msg);
        }
        if ($usuario["usu_estado"] == 1 && $usuario["usu_activo"] == 1) {
            $_SESSION['lnh'] = $usuario['idwebusuario'];
            $_SESSION['pe'] = true;
            $msg = "Bienvenido! " . $usuario["usu_nombre"];
            return $this->respondWithJson($response, ["status" => true, "message" => $msg]);
        }
        $msg = "Erorr inesperado";
        return $this->respondWithError($response, $msg);
    }

    private function respondWithError($response, $message)
    {
        return $this->respondWithJson($response, ["status" => false, "message" => $message]);
    }

    private function respondWithJson($response, $data)
    {
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
