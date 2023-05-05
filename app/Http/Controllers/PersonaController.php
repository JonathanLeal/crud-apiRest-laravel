<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function obtenerPersonas(){
        $personas = Persona::all();
        if (count($personas) == 0) {
            return Http::respuesta(http::retNotFound, "no hay personas");
        }
        return http::respuesta(http::retOK, $personas);
    }

    public function obtenerPersonaPorId(Request $request){
        $idPersona = Persona::find($request->id);
        if (!$idPersona) {
            return http::respuesta(http::retNotFound, "no se encontro ese ID");
        }
        return http::respuesta(http::retOK, $idPersona);
    }
}
