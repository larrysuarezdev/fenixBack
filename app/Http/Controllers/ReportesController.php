<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Credito;
use DB;

class ReportesController extends Controller
{
    public function getCoteos(Requests\CoteosRequest $request)
    {
        $input = $request->all();
        $FI = $input['fechaIni'];
        $FF = $input['fechaFin'];
        // var_dump($input);
        // $v->whereBetween('fecha', [$input['fechaIni'], $input['FechaFin']]);
        $cobradores = User::
            // with('coteos')
            with(['coteos' => function ($query) use ($FI, $FF) {
                $query->whereBetween('fecha', [$FI, $FF]);
            }])
            ->where([["login", false]])->orderBy("ruta")->get();

        return response()->json([
            'data' => $cobradores
        ]);
    }
}
