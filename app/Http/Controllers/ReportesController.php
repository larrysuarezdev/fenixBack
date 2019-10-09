<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\FlujoUtilidade;
use App\FlujoCaja;

class ReportesController extends Controller
{
    public function getCoteos(Requests\CoteosRequest $request)
    {
        $input = $request->all();
        $FI = $input['fechaIni'];
        $FF = $input['fechaFin'];

        $cobradores = User::with(['coteos' => function ($query) use ($FI, $FF) {
                $query->whereBetween('fecha', [$FI, $FF]);
            }])
            ->where([["login", false]])->orderBy("ruta")->get();

        $utilidades = FlujoUtilidade::where('descripcion', 'like', '%Utilidad ruta %')
            ->whereBetween('fecha', [$FI, $FF])
            ->get();

        $recaudos = FlujoCaja::where('descripcion', 'like', '%Cobros ruta %')
            ->whereBetween('fecha', [$FI, $FF])
            ->get();

        return response()->json([
            'data' => $cobradores,
            'utilidades' => $utilidades,
            'recaudos' => $recaudos,
        ]);
    }
}
