<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\FlujoUtilidade;

class FlujoUtilidadesController extends Controller
{
    public function getFlujoUtilidades()
    {
        $flujoCaja = FlujoUtilidade::get();

        return response()->json(['data' => $flujoCaja]);
    }

    public function postSaveFlujo(Requests\FlujoUtilidadesRequest $request)
    {
        $input = $request->all();

        $flujoCaja = new FlujoUtilidade;
        $flujoCaja->descripcion = $input["descripcion"];
        $flujoCaja->valor = $input["valor"];
        $flujoCaja->fecha = $input["fecha"];
        $flujoCaja->tipo = $input["tipo"];

        $flujoCaja->save();

        $flujoCaja = FlujoUtilidade::get();

        return response()->json(['data' => $flujoCaja]);
    }
}
