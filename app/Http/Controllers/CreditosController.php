<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Credito;
use App\CreditosDetalle;
use Carbon\Carbon;
use JWTAuth;
use DB;

class CreditosController extends Controller
{
    public function getCredito($id)
    {
        $creditos = Credito::getCreditos($id);

        return response()->json(['data' => $creditos]);
    }

    public function postCredito(Requests\addCreditoRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();

        $credito = new Credito();
        $credito->cliente_id = $input['cliente_id'];
        $credito->ruta_id = $input['ruta_id'];
        $credito->inicio_credito = $input['inicio_credito'];
        $credito->valor_prestamo = $input['valor_prestamo'];
        $credito->mod_cuota = $input['mod_cuota'];
        $credito->mod_dias = $input['mod_dias'];
        $credito->save();

        $creditos = Credito::getCreditos($input['ruta_id']);
        $credito->orden = count($creditos);
        $credito->save();

        DB::commit();

        $creditos = Credito::getCreditos($input['ruta_id']);

        return response()->json(['data' => $creditos]);
    }

    public function postAbonos(Requests\addCuotasRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $input = $request->all();

        DB::beginTransaction();

        foreach ($input['cuotas'] as $key => $value) {
            $creditoDetalle = new CreditosDetalle();
            $creditoDetalle->credito_id = $value['id'];
            $creditoDetalle->abono = $value['cuota'];
            $creditoDetalle->fecha_abono = Carbon::now()->toDateString();;
            $creditoDetalle->cliente_id = $user->id;
            $creditoDetalle->save();
        }

        DB::commit();

        $creditos = Credito::getCreditos($input['idRuta']);
        
        return response()->json(['data' => $creditos]);
    }
}
