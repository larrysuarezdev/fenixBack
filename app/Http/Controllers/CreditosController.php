<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Credito;
use App\Cliente;
use App\Coteo;
use App\CreditosDetalle;
use App\CreditosRenovacione;
use Carbon\Carbon;
use JWTAuth;
use DB;
use App\FlujoCaja;
use App\FlujoUtilidade;
use App\User;

class CreditosController extends Controller
{
    public function getCredito($id)
    {
        $creditos = Credito::getCreditos($id);
        $cobrador = User::where([['ruta', $id], ['login', false]])->first();

        return response()->json(['data' => $creditos, 'cobrador' => $cobrador]);
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
            $credito->obs_dia = $input['obs_dia'];            
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

        return response()->json(['data' => $creditos, 'cobrador' => $cobrador]);
    }

    public function postAbonos(Requests\addCuotasRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $input = $request->all();

        DB::beginTransaction();
        $utilidad = 0;
        $orden = 1;

        foreach ($input['eliminar'] as $key => $value) {
            $credito = Credito::find($value['id']);
            $credito->activo = false;
            $credito->orden = null;
            $credito->eliminado = true;
            $credito->save();
        }

        foreach ($input['cuotas'] as $key => $value) {
            if ($value['cuota'] != null) {
                $creditoDetalle = new CreditosDetalle();
                $creditoDetalle->credito_id = $value['id'];
                $creditoDetalle->abono = $value['cuota'];
                $creditoDetalle->fecha_abono = Carbon::now()->toDateString();
                $creditoDetalle->usuario_id = $user->id;
                $creditoDetalle->save();
            }

            $credito = Credito::with(['creditos_detalles' => function ($v) {
                $v->where('estado', true);
            }])
                ->where([['id', $value['id']], ['activo', true]])->orderBy('orden', 'ASC')
                ->get();
            $estado = true;

            $valor_total = $credito[0]->mod_cuota * $credito[0]->mod_dias;
            $total_pago_fecha = $credito[0]->creditos_detalles->sum('abono');

            if ($valor_total == $total_pago_fecha) {
                $estado = false;
            }

            $credito[0]->obs_dia = $value['obs'];
            $credito[0]->activo = $estado;

            if (!$estado) {
                $credito[0]->mora = 0;
                $credito[0]->orden = null;
                $sum = ($credito[0]->mod_cuota * $credito[0]->mod_dias) - $credito[0]->valor_prestamo;
                $utilidad = $utilidad + $sum;
            } else {
                $credito[0]->orden = $orden;
                $orden = $orden + 1;

                if ($input["calculoMoras"]) {
                    if ($value['cuota'] == null)
                        $credito[0]->mora = $credito[0]->mora + 1;
                    else {
                        if ($credito[0]->modalidad == 1) {
                            if ($value['cuota'] < $credito[0]->mod_cuota)
                                $credito[0]->mora = $credito[0]->mora;
                            else {
                                $moraDias = (int) $value['cuota'] / $credito[0]->mod_cuota;

                                if ($moraDias >= 2)
                                    $credito[0]->mora = $credito[0]->mora - ($moraDias - 1);
                            }
                        } else {
                            if ($value['cuota'] < $credito[0]->mod_cuota)
                                $credito[0]->mora = $credito[0]->mora + 1;
                            else {
                                $credito[0]->mora = 0;
                            }
                        }
                    }
                }
            }

            $credito[0]->save();
        }

        foreach ($input['renovaciones'] as $key => $value) {

            CreditosRenovacione::ChangeStateRenovacion($value['id']);
            $renovacion = new CreditosRenovacione();
            $renovacion->credito_id = $value['id'];
            $renovacion->excedente = $value['excedente'];
            $renovacion->observaciones = $value['observaciones'];

            $renovacion->estado = true;
            $renovacion->fecha = Carbon::now()->toDateString();
            $renovacion->save();

            $credito = Credito::find($value['id']);
            $credito->modalidad = $value['modalidad'];
            $credito->mod_dias = $value['dias'];
            $credito->mod_cuota = $value['cuota'];
            $credito->valor_prestamo = $value['valor_prestamo'];
            $credito->mora = 0;
            $credito->save();

            $creditoDetalle = CreditosDetalle::where([['credito_id', $value['id'], ['estado', true]]])->get();
            foreach ($creditoDetalle as $key => $valueCD) {
                $credDet = CreditosDetalle::find($valueCD['id']);
                $credDet->estado = false;
                $credDet->save();
            }
        }

        if ($input['flujoCaja']['entrada'] > 0) {
            $flujo = new FlujoCaja();
            $flujo->descripcion = "Cobros ruta " . $input['idRuta'];
            $flujo->tipo = 1;
            $flujo->valor = $input['flujoCaja']['entrada'];
            $flujo->fecha = Carbon::now();
            $flujo->save();
        }

        if ($input['flujoCaja']['salida'] > 0) {
            $flujo = new FlujoCaja();
            $flujo->descripcion = "Prestamos ruta " . $input['idRuta'];
            $flujo->tipo = 2;
            $flujo->valor = $input['flujoCaja']['salida'];
            $flujo->fecha = Carbon::now();
            $flujo->save();
        }

        $sumUtilidad = $input['flujoCaja']['utilidad'] + $utilidad;

        if ($sumUtilidad > 0) {
            $flujoUtilidad = new FlujoUtilidade();
            $flujoUtilidad->descripcion = "Utilidad ruta " . $input['idRuta'];
            $flujoUtilidad->valor = $sumUtilidad;
            $flujoUtilidad->fecha = Carbon::now();
            $flujoUtilidad->tipo = 1;
            $flujoUtilidad->save();
        }

        if ($input['flujoCaja']['coteos'] > 0) {
            $coteos = new Coteo();
            $coteos->coteos_dia = $input['flujoCaja']['coteos'];
            $coteos->id_ruta = $input['idRuta'];
            $coteos->fecha = Carbon::now()->toDateString();
            $coteos->total_creditos_dia = Credito::where([['ruta_id', $input['idRuta']], ['activo', true], ['modalidad', 1]])->count();
            $coteos->total_creditos_sem = Credito::where([['ruta_id', $input['idRuta']], ['activo', true], ['modalidad', 2]])->count();

            $user = DB::table('users')->select(DB::raw('id'))->where([['ruta', $input['idRuta']], ['login', false]])->first();

            $coteos->id_usuario = $user->id;
            $coteos->save();
        }

        DB::commit();

        $creditos = Credito::getCreditos($input['idRuta']);
        $cobrador = User::where([['ruta', $input['idRuta']], ['login', false]])->first();

        return response()->json(['data' => $creditos, 'cobrador' => $cobrador]);
    }

    // public function postSetEstadosCreditos(Requests\ReorderRequest $request)
    // {
    //     $input = $request->all();

    //     DB::beginTransaction();
    //     // var_dump($input['data']);

    //     $credito = Credito::whereIn('id', $input['data'])->get();
    //     // var_dump($credito);

    //     $utilidad = 0;
    //     $orden = 1;
    //     foreach ($credito as $key => $value) {
    //         $estado = Credito::ChangeStateCredito($value->id);
    //         $value->activo = $estado;

    //         if (!$estado) {
    //             $value->orden = null;
    //             $utilidad = $utilidad + (($value->mod_cuota * $value->mod_dias) - $value->valor_prestamo);
    //         } else {
    //             $value->orden = $orden;
    //             $orden = $orden + 1;
    //         }

    //         $value->save();
    //     }

    //     if ($utilidad > 0) {
    //         $flujoUtilidad = new FlujoUtilidade();
    //         $flujoUtilidad->descripcion = "Utilidad ruta " . $input['idRuta'] . "";
    //         $flujoUtilidad->valor = $utilidad;
    //         $flujoUtilidad->fecha = Carbon::now();
    //         $flujoUtilidad->tipo = 1;
    //         $flujoUtilidad->save();
    //     }

    //     DB::commit();

    //     $creditos = Credito::getCreditos($input['idRuta']);
    //     $cobrador = User::where([['ruta', $input['idRuta']], ['login', false]])->first();

    //     return response()->json(['data' => $creditos, 'cobrador' => $cobrador]);
    // }

    public function postRenovaciones(Requests\RenovacionesRequest $request)
    {
        $input = $request->all();

        $credito = Credito::with(['creditos_detalles' => function ($v) {
            $v->where('estado', true);
        }])->where('id', $input['id'])->get();

        $valor_total = $credito[0]->mod_cuota * $credito[0]->mod_dias;
        $interes = $valor_total - $credito[0]->valor_prestamo;
        $total_pago_fecha = $credito[0]->creditos_detalles->sum('abono');

        if ($total_pago_fecha >= $interes) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['Error' => "El crédito no cumple con los requisitos minímos para renovar"], 424);
        }
    }

    public function getClientes()
    {
        // $clientes = Cliente::get();
        $clientes = Cliente::where('estado', true)->get();
        return response()->json(['data' => $clientes]);
    }
}
