<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Credito;
use App\CreditosDetalle;
use Carbon\Carbon;
use JWTAuth;
use DB;
use App\FlujoCaja;

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
        if (!Credito::CreditoUsuarioActivo($input['cliente_id'])) {
            DB::beginTransaction();

            $credito = new Credito();
            $credito->cliente_id = $input['cliente_id'];
            $credito->ruta_id = $input['ruta_id'];
            $credito->inicio_credito = $input['inicio_credito'];
            $credito->valor_prestamo = $input['valor_prestamo'];
            $credito->mod_cuota = $input['mod_cuota'];
            $credito->mod_dias = $input['mod_dias'];
            $credito->observaciones = $input['observaciones'];
            $credito->save();

            $creditos = Credito::getCreditos($input['ruta_id']);
            $credito->orden = count($creditos);
            $credito->save();

            DB::commit();
        }else{
            return response()->json(['Error' => 'El cliente tiene actualmente un credito activo'], 423);
        }

        $creditos = Credito::getCreditos($input['ruta_id']);

        return response()->json(['data' => $creditos]);
    }

    public function postAbonos(Requests\addCuotasRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $input = $request->all();

        DB::beginTransaction();

        foreach ($input['cuotas'] as $key => $value) {
            if ($value['cuota'] != null) {
                $creditoDetalle = new CreditosDetalle();
                $creditoDetalle->credito_id = $value['id'];
                $creditoDetalle->abono = $value['cuota'];
                $creditoDetalle->fecha_abono = Carbon::now()->toDateString();
                $creditoDetalle->usuario_id = $user->id;
                $creditoDetalle->save();
            }
            $credito = Credito::find($value['id']);
            $credito->orden = $value['orden'];
            $credito->save();
        }

        $flujo = new FlujoCaja();
        $flujo->descripcion = "Entrada en ruta " . $input['idRuta'];
        $flujo->tipo = 1;
        $flujo->valor = $input['flujoCaja']['entrada'];
        $flujo->fecha = Carbon::now();
        $flujo->save();

        DB::commit();

        $creditos = Credito::getCreditos($input['idRuta']);

        return response()->json(['data' => $creditos]);
    }

    public function postRenovaciones(Requests\RenovacionesRequest $request)
    {
        $input = $request->all();

        $credito = Credito::find($input['id'])->get();

        error_log('estraaaaaaaaaaaaaaaaa');

        // DB::beginTransaction();

        // foreach ($input['cuotas'] as $key => $value) {
        //     $creditoDetalle = new CreditosDetalle();
        //     $creditoDetalle->credito_id = $value['id'];
        //     $creditoDetalle->abono = $value['cuota'];
        //     $creditoDetalle->fecha_abono = Carbon::now()->toDateString();;
        //     $creditoDetalle->usuario_id = $user->id;
        //     $creditoDetalle->save();
        // }

        // DB::commit();

        // $creditos = Credito::getCreditos($input['1']);

        return response()->json(['data' => $credito]);
    }
}
