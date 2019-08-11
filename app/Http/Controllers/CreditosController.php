<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Credito;
use App\Cliente;
use App\CreditosDetalle;
use App\CreditosRenovacione;
use Carbon\Carbon;
use JWTAuth;
use DB;
use App\FlujoCaja;
use App\User;

class CreditosController extends Controller
{
    public function getCredito($id)
    {
        $creditos = Credito::getCreditos($id);
        $cobrador = User::where([['ruta', $id], ['login', false]])->first();

        return response()->json(['data' => $creditos, 'cobrador' => $cobrador ]);
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
            $credito->modalidad = $input['modalidad'];
            $credito->save();

            $creditos = Credito::getCreditos($input['ruta_id']);
            $credito->orden = count($creditos);
            $credito->save();

            DB::commit();
        } else {
            return response()->json(['Error' => 'El cliente tiene actualmente un crédito activo'], 423);
        }

        $creditos = Credito::getCreditos($input['ruta_id']);

        $cobrador = User::where([['ruta', $input['ruta_id']], ['login', false]])->first();

        return response()->json(['data' => $creditos, 'cobrador' => $cobrador ]);
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

        foreach ($input['renovaciones'] as $key => $value) {
            $renovacion = new CreditosRenovacione();
            $renovacion->credito_id = $value['id'];
            $renovacion->excedente = $value['excedente'];
            $renovacion->observaciones = $value['observaciones'];

            $renovacion->estado = true;
            $renovacion->fecha = Carbon::now()->toDateString();
            $renovacion->save();

            $credito->modalidad = $value['modalidad'];
            $credito->save();

            $creditoDetalle = CreditosDetalle::where([['credito_id', $value['id'], ['estado', true]]])->get();
            foreach ($creditoDetalle as $key => $valueCD) {
                $credDet = CreditosDetalle::find($valueCD['id']);
                $credDet->estado = false;
                $credDet->save();
            }
        }

        $flujo = new FlujoCaja();
        $flujo->descripcion = "Entrada en ruta " . $input['idRuta'];
        $flujo->tipo = 1;
        $flujo->valor = $input['flujoCaja']['entrada'];
        $flujo->fecha = Carbon::now();
        $flujo->save();

        $flujo = new FlujoCaja();
        $flujo->descripcion = "Salida en ruta " . $input['idRuta'];
        $flujo->tipo = 2;
        $flujo->valor = $input['flujoCaja']['salida'];
        $flujo->fecha = Carbon::now();
        $flujo->save();

        DB::commit();

        $creditos = Credito::getCreditos($input['idRuta']);

        $cobrador = User::where([['ruta', $input['idRuta']], ['login', false]])->first();

        return response()->json(['data' => $creditos, 'cobrador' => $cobrador ]);
    }

    public function postRenovaciones(Requests\RenovacionesRequest $request)
    {
        $input = $request->all();

        $credito = Credito::with('creditos_detalles')->where('id', $input['id'])->get();

        $valor_total = $credito[0]->mod_cuota * $credito[0]->mod_dias;
        $interes = $valor_total - $credito[0]->valor_prestamo;
        $total_pago_fecha = $credito[0]->creditos_detalles->sum('abono');

        if ($total_pago_fecha >= $interes) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['Error' => "El crédito no cumple con los requisitos minímos para renovar"], 424);
        }

        // DB::commit();

        // $creditos = Credito::getCreditos($input['1']);

        // return response()->json(['data' => $credito]);
    }

    public function getClientes()
    {
        // $clientes = Cliente::get();
        $clientes = Cliente::where('estado', true)->get();
        return response()->json(['data' => $clientes]);
    }
}
