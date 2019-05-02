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

}
