<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\FlujoCaja;


class FlujoCajaController extends Controller
{
    
    public function getFlujoCaja()
    {
        $flujoCaja = FlujoCaja::orderBy('fecha', 'desc')->get();

        return response()->json(['data' => $flujoCaja]);
    }

    public function postSaveFlujo(Requests\FlujoCajaRequest $request)
    {
        $input = $request->all();

        $flujoCaja = new FlujoCaja;
        $flujoCaja->descripcion = $input["descripcion"];
        $flujoCaja->tipo = $input["tipo"];
        $flujoCaja->valor = $input["valor"];
        $flujoCaja->fecha = $input["fecha"];

        $flujoCaja->save();

        $flujoCaja = FlujoCaja::get();

        return response()->json(['data' => $flujoCaja]);
    }
}
