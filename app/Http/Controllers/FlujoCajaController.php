<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\FlujoCaja;
use App\FlujoUtilidade;


class FlujoCajaController extends Controller
{
    
    public function getFlujoCaja()
    {
        $flujoCaja = FlujoCaja::orderBy('fecha', 'desc')->paginate(1000);
        

        $entrada = FlujoCaja::where('tipo', 1)->sum('valor');
        $salidas = FlujoCaja::where('tipo', 2)->sum('valor');
        $sum = $entrada - $salidas;

        return response()->json(['data' => $flujoCaja, 'sum' => $sum]);
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

    public function getFlujoUtilidades()
    {
        $FlujoUtilidades = FlujoUtilidade::orderBy('fecha', 'desc')->paginate(1000);
        

        $entrada = FlujoUtilidade::where('tipo', 1)->sum('valor');
        $salidas = FlujoUtilidade::where('tipo', 2)->sum('valor');
        $sum = $entrada - $salidas;

        return response()->json(['data' => $FlujoUtilidades, 'sum' => $sum]);
        // try {
        //     $FlujoUtilidades = FlujoUtilidade::orderBy('fecha', 'desc')->get();
        //     return response()->json(['data' => $FlujoUtilidades]);
        // } catch (Exception $e) {
        //     return response()->json(['Error' => $e], 423);
        // }
    }

    public function postSaveFlujoUtilidades(Requests\FlujoUtilidadesRequest $request)
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
