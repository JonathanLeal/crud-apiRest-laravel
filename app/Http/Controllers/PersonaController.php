<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function guardarPersona(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'edad' => 'required|integer|min:1',
            'identificacion' => 'required|identificacion|unique:personas,identificacion',
            'ocupacion' => 'required|string'
        ]);

        if ($validator->fails()) {
            return http::respuesta(http::retError, $validator->errors());
        }

        DB::beginTransaction();
        try {
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->edad = $request->edad;
            $persona->identificacion = $request->identificacion;
            $persona->ocupacion = $request->ocupacion;
            $persona->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            return http::respuesta(http::retError, ['error cacth:' => $th->getMessage()]);
        }
        DB::commit();
        return http::respuesta(http::retOK, "Persona guardada correctamente");
    }
}
