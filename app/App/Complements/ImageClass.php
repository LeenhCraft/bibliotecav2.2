<?php

namespace App\Complements;

use App\Http\Imagenes;

class ImageClass
{
    public function cargarImagen($photo, $type = null, $isArray = false)
    {
        // segun el tipo se guardara en diferentes directorios en /public/img/
        // si $isArray es true significa que estaenviando más de una foto
        $class = new Imagenes;
        $validate = $class->validarImagen($photo);
        return $validate;
    }
}
