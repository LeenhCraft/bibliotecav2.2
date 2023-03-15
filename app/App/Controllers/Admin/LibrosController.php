<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\MenuModel;
use App\Models\TableModel;

use Slim\Csrf\Guard;
use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LibrosController extends Controller
{

    protected $permisos = [];
    protected $responseFactory;
    protected $guard;

    public function __construct()
    {
        parent::__construct();
        $this->permisos = getPermisos($this->className($this));
        $this->responseFactory = new ResponseFactory();
        $this->guard = new Guard($this->responseFactory);
    }

    public function index($request, $response)
    {
        // return $response;
        // $this->guard->removeAllTokenFromStorage();
        return $this->render($response, 'App.Libros.libros', [
            'titulo_web' => 'Libros',
            "url" => $request->getUri()->getPath(),
            "permisos" => $this->permisos,
            'js' => [
                'js/app/plugins/ckeditor/ckeditor.js',
                'js/app/sample.js',
                'js/app/libros.js',
            ],
            "tk" => [
                "name" => $this->guard->getTokenNameKey(),
                "value" => $this->guard->getTokenValueKey(),
                "key" => $this->guard->generateToken()
            ]
        ]);
    }

    public function list($request, $response)
    {
        $model = new TableModel;
        $model->setTable('bib_libros');
        $model->setId("idlibro");

        $arrData = $model->orderBy("idlibro", "DESC")->get();
        $data = [];

        $nmr = 0;
        for ($i = 0; $i < count($arrData); $i++) {
            $btnEdit = "";
            $btnDelete = "";
            $nmr++;
            if ($arrData[$i]['lib_estado'] == 1) {
                $data[$i]['status'] = "<i class='bx-1 bx bx-check text-success'></i>";
            } else {
                $data[$i]['status'] = "<i class='bx-1 bx bx-x text-danger'></i>";
            }
            if ($arrData[$i]['lib_publicar'] == 1) {
                $data[$i]['web'] = "<i class='bx-1 bx bx-check text-success'></i>";
            } else {
                $data[$i]['web'] = "<i class='bx-1 bx bx-x text-danger'></i>";
            }
            if ($this->permisos['perm_u'] == 1) {
                $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrData[$i]['idlibro'] . ')" title="Editar Libro"><i class="bx bxs-edit-alt"></i></button>';
            }
            if ($this->permisos['perm_d'] == 1) {
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDel(' . $arrData[$i]['idlibro'] . ')" title="Eliminar Libro"><i class="bx bxs-trash-alt" ></i></button>';
            }

            $data[$i]['options'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btnEdit . ' ' . $btnDelete . '</div>';
            $data[$i]['num'] = $nmr;
            $data[$i]['name'] = $arrData[$i]['lib_titulo'];
        }
        return $this->respondWithJson($response, $data);
    }

    public function store(Request $request, Response $response)
    {
        $data = $this->sanitize($request->getParsedBody());
        // return $this->respondWithJson($response, $data);

        $validate = $this->guard->validateToken($data['csrf_name'], $data['csrf_value']);
        if (!$validate) {
            $msg = "Error de validación, por favor recargue la página";
            return $this->respondWithError($response, $msg);
        }

        $errors = $this->validar($data);
        if (!$errors) {
            $msg = "Verifique los datos ingresados";
            return $this->respondWithError($response, $msg);
        }

        $model = new TableModel;
        $model->setTable("bib_libros");
        $model->setId("idlibro");

        $existe = $model->orWhere("lib_titulo", $data['name'])->orWhere("lib_slug", $data['slug'])->where("lib_estado", '1')->first();
        if (!empty($existe)) {
            $msg = "Ya existe un articulo con el mismo nombre o slug";
            return $this->respondWithError($response, $msg);
        }

        $data['slug'] = $data['slug'] ?? urls_amigables($data['name']);
        $rq = $model->create([
            "idarticulo" => $data['idarticulo'] ?? 0,
            "ideditorial" => $data['ideditorial'] ?? 0,
            "lib_titulo" => ucfirst($data['name']) ?? "UNDEFINED",
            "lib_slug" => strtolower($data['slug']),
            "lib_descripcion" => $data['description'],
            "lib_fecha_publi" => $data['date_publish'],
            "lib_num_paginas" => $data['pages'],
            "lib_estado" => isset($data['status']) && $data['status'] == "on" ? '1' : "0",
            "lib_publicar" => isset($data['publish']) && $data['publish'] == "on" ? '1' : "0",
        ]);
        if (!empty($rq)) {
            $msg = "Datos guardados correctamente";
            return $this->respondWithSuccess($response, $msg);
        }
        $msg = "Error al guardar los datos";
        return $this->respondWithJson($response, $existe);
    }

    public function validar($data)
    {

        if (empty("idarticulo")) {
            return false;
        }
        if (empty("idautor")) {
            return false;
        }
        if (empty("ideditorial")) {
            return false;
        }
        if (empty("name")) {
            return false;
        }
        return true;
    }

    public function search($request, $response)
    {
        $data = $this->sanitize($request->getParsedBody());

        $errors = $this->validarSearch($data);
        if (!$errors) {
            $msg = "Verifique los datos ingresados";
            return $this->respondWithError($response, $msg);
        }

        $model = new TableModel;
        $model->setTable("bib_libros");
        $model->setId("idlibro");

        $rq = $model->find($data['id']);
        if (!empty($rq)) {
            return $this->respondWithJson($response, ["status" => true, "data" => $rq]);
        }
        $msg = "No se encontraron datos";
        return $this->respondWithError($response, $msg);
    }

    public function validarSearch($data)
    {
        if (empty($data["id"])) {
            return false;
        }
        return true;
    }

    public function update($request, $response)
    {
        $data = $this->sanitize($request->getParsedBody());
        // return $this->respondWithJson($response, $data);

        $validate = $this->guard->validateToken($data['csrf_name'], $data['csrf_value']);
        if (!$validate) {
            $msg = "Error de validación, por favor recargue la página";
            return $this->respondWithError($response, $msg);
        }

        $errors = $this->validarUpdate($data);
        if (!$errors) {
            $msg = "Verifique los datos ingresados";
            return $this->respondWithError($response, $msg);
        }

        $model = new TableModel;
        $model->setTable("bib_libros");
        $model->setId("idlibro");

        $existe = $model->query("SELECT SQL_CALC_FOUND_ROWS * FROM bib_libros WHERE (lib_titulo = ? OR lib_slug = ?) AND idlibro != ?", [$data['name'], $data['slug'], $data['id']])->first();
        if (!empty($existe)) {
            $msg = "Ya tiene un libro con el mismo nombre o slug";
            return $this->respondWithError($response, $msg);
        }

        $data['slug'] = $data['slug'] ?? urls_amigables($data['name']);
        $rq = $model->update($data['id'], [
            "idarticulo" => $data['idarticulo'] ?? 0,
            "ideditorial" => $data['ideditorial'] ?? 0,
            "lib_titulo" => ucfirst($data['name']) ?? "UNDEFINED",
            "lib_slug" => strtolower($data['slug']),
            "lib_descripcion" => $data['description'],
            "lib_fecha_publi" => $data['date_publish'],
            "lib_num_paginas" => $data['pages'],
            "lib_estado" => isset($data['status']) && $data['status'] == "on" ? '1' : "0",
            "lib_publicar" => isset($data['publish']) && $data['publish'] == "on" ? '1' : "0",
        ]);
        if (!empty($rq)) {
            $msg = "Datos actualizados";
            return $this->respondWithSuccess($response, $msg);
        }
        $msg = "Error al guardar los datos";
        return $this->respondWithJson($response, $existe);
    }

    private function validarUpdate($data)
    {
        if (empty($data["id"])) {
            return false;
        }
        if (empty("idarticulo")) {
            return false;
        }
        if (empty("idautor")) {
            return false;
        }
        if (empty("ideditorial")) {
            return false;
        }
        if (empty("name")) {
            return false;
        }
        return true;
    }

    public function delete($request, $response)
    {
        $data = $this->sanitize($request->getParsedBody());
        if (empty($data["id"])) {
            return $this->respondWithError($response, "Error de validación, por favor recargue la página");
        }

        $model = new TableModel;
        $model->setTable("bib_libros");
        $model->setId("idlibro");

        $rq = $model->find($data["id"]);
        if (!empty($rq)) {

            // $libro = $model->query("SELECT * FROM `bib_libros` WHERE `idarticulo` = {$data["id"]}")->first();

            // if (!empty($libro)) {
            //     $msg = "No se puede eliminar el registro, ya que tiene un libro asociado";
            //     return $this->respondWithError($response, $libro);
            // }

            $rq = $model->delete($data["id"]);
            if (!empty($rq)) {
                $msg = "Datos eliminados correctamente";
                return $this->respondWithSuccess($response, $msg);
            }
            $msg = "Error al eliminar los datos";
            return $this->respondWithError($response, $msg);
        }
        $msg = "No se encontraron datos para eliminar.";
        return $this->respondWithError($response, $msg);
    }

    public function autores($request, $response)
    {
        $model = new TableModel;
        $arrData = $model->query("SELECT idautor as id, aut_nombre as nombre FROM bib_autores WHERE aut_estado = 1 ORDER BY idautor ASC")->get();
        return $this->respondWithJson($response, ["status" => true, "data" => $arrData]);
    }

    public function editoriales($request, $response)
    {
        $model = new TableModel;
        $arrData = $model->query("SELECT ideditorial as id, edi_nombre as nombre FROM bib_editoriales WHERE edi_estado = 1 ORDER BY ideditorial ASC")->get();
        return $this->respondWithJson($response, ["status" => true, "data" => $arrData]);
    }

    public function articulos($request, $response)
    {
        $model = new TableModel;
        $arrData = $model->query("SELECT idarticulo as id, art_nombre as nombre FROM bib_articulos WHERE art_estado = 1 ORDER BY idarticulo ASC")->get();
        return $this->respondWithJson($response, ["status" => true, "data" => $arrData]);
    }
}
