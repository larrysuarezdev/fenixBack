<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\FlujoUtilidade;

class FlujoUtilidadesController extends Controller
{
    public function getFlujoUtilidades()
    {
        try {
            $flujoCaja = FlujoUtilidade::get();
            return response()->json(['data' => $flujoCaja]);
        } catch (Exception $e) {
            return response()->json(['Error' => $e], 423);
        }
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
