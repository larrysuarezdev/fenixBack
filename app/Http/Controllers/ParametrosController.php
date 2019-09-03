<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Parametro;
use App\ParametrosDetalle;
use JWTAuth;
use DB;


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

    public function getPeriodos()
    {
        $parametros = Parametro::with('parametros_detalles')->where('nombre', 'Modos de pago')->get();

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

    public function getRoles()
    {
        $parametros = Parametro::with('parametros_detalles')->where('nombre', 'Roles')->get();

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

    public function postParametros(Requests\ParametroRequest $request)
    {
        $input = $request->all();

        $parametro = new ParametrosDetalle();
        $parametro->id_interno = $input['id_interno'];
        $parametro->valor = $input['valor'];
        $parametro->parametro_id = $input['parametro_id'];

        $parametro->save();
        return response()->json(['data' => $parametro]);
    }

    public function putParametros(Requests\ParametroPutRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();

        foreach ($input['cambios'] as $key => $value) {
            if (isset($value['updated'])) {
                $parametro = ParametrosDetalle::find($value['id']);
                $parametro->valor = $value['valor'];
                $parametro->save();
            }
        }

        DB::commit();

        return response()->json(['data' => 'OK']);
    }
}
