<?php

namespace App\Controllers\Login;

use App\Controllers\Controller;
use App\Models\UsuarioModel;

class RegisterController extends Controller
{
    public function index($request, $response, $args)
    {
        $return = $this->view("Web.register", [
            "data" => [
                'title' => 'Register',
            ],
            "js" => ["js/web/register.js", "js/web/resend_email.js"]
        ]);
        $response->getBody()->write($return);
        return $response;
    }

    public function save($request, $response, $args)
    {
        $data = $this->sanitizar($request->getParsedBody()); // obtenemos los datos del formulario y sanitizamos los datos

        $errors = $this->validar($data); // validamos los datos
        if (!$errors) { // si hay errores
            $rq = json_encode([
                "status" => false,
                "message" => "Verifique los datos ingresados",
                "errors" => $errors,
            ]);

            $response->getBody()->write($rq);

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }

        $token = token(7); // generamos un token
        $data["token"] = $token; // agregamos el token al array de datos
        $data['expires'] = time() + 24 * 60 * 60; // 24 horas

        $usuarioModel = new UsuarioModel(); // instanciamos el modelo

        $exist = $usuarioModel->where("usu_usuario", "LIKE", $data["email"])->first(); // verificamos si el email ya se encuentra registrado
        if ($exist) {
            $rq = json_encode([
                "status" => false,
                "message" => "El email ya se encuentra registrado",
            ]);

            $response->getBody()->write($rq);

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }

        $rq = $usuarioModel->save($data); // guardamos los datos

        if (!empty($rq)) {
            // enviar email de confirmacion
            $this->sendEmail([
                "nombre" => $rq['usu_nombre'],
                "email" => $rq['usu_usuario'],
                "token" => $rq['usu_token'],
                "expires" => $rq['usu_expire'],
            ]);

            $rq = [
                "status" => true,
                "message" => "Datos guardados correctamente",
                "data" => [
                    "name" => $rq['usu_nombre'],
                    "token" => $rq['usu_token']
                ]
            ];
        } else {
            $rq = [
                "status" => false,
                "message" => "Error al guardar los datos",
            ];
        }


        $rq = json_encode($rq);

        $response->getBody()->write($rq);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    private function validar($data)
    {
        // $errors = [];
        if (empty($data["dni"]) || strlen($data["dni"]) != 8) {
            // $errors["dni"] = "El campo DNI es obligatorio";
            return false;
        }
        if (empty($data["name"])) {
            // $errors["name"] = "El campo Nombre es obligatorio";
            return false;
        }
        if (empty($data["email"]) || !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            // $errors["email"] = "El campo Email es obligatorio";
            return false;
        }
        if (empty($data["password"])) {
            // $errors["password"] = "El campo Contraseña es obligatorio";
            return false;
        }
        if (empty($data["password_confirmation"])) {
            // $errors["password_confirmation"] = "El campo Confirmar Contraseña es obligatorio";
            return false;
        }
        if ($data["password"] != $data["password_confirmation"]) {
            // $errors["password_confirmation"] = "Las contraseñas no coinciden";
            return false;
        }
        return true;
    }

    public function sanitizar($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = strClean($value);
        }
        return $data;
    }

    public function sendEmail($data = [])
    // public function sendEmail($request, $response, $args)
    {
        // $data = [
        //     "nombre" => 'matts',
        //     "email" => 'hackingleenh@gmail.com',
        //     "token" => 'usu_token',
        //     "expires" => time()
        // ];

        if (empty($data)) return false;

        $url_recovery = base_url() . 'verify-email/' . $data["token"] .
            // '?email=' . $data["email"] .
            '?expires=' . $data["expires"] .
            '&signature=' . generateSignature($data["token"], $data["expires"]);

        $dataUsuario = array(
            'nombre' => $data['nombre'],
            'email' => $data["email"],
            'asunto' => "Confirme su dirección de correo electrónico.",
            'url_recovery' => $url_recovery
        );
        $response_email = enviarEmail($dataUsuario, 'email');
        return $response_email;

        // $response->getBody()->write("{$response_email}");
        // return $response;
    }
}
