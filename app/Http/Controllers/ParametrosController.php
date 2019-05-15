<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Parametro;
use JWTAuth;


class ParametrosController extends Controller
{
    public function getParametros()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $parametros = Parametro::with('parametros_detalles')->get();

        return response()->json(['data' => $parametros]);
    }

    public function getRutas()
    {
        $parametros = Parametro::with('parametros_detalles')->where('nombre', 'Rutas')->get();

        $rutas = array();
        foreach ($parametros as $key => $value) {
            foreach ($value->parametros_detalles as $key1 => $valueP) {
                $rutas[] = array(
                    'value' => $valueP['id_interno'],
                    'label' => $valueP['valor']
                );
            }
        }

        return response()->json(['data' => $rutas]);
    }
}
