<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\FlujoUtilidade;
use App\FlujoCaja;
use App\Credito;
use App\CreditosRenovacione;

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

        $nuevos = Credito::whereBetween('inicio_credito', [$FI, $FF])->get();
        $renovaciones = CreditosRenovacione::with(['credito' => function ($query){
            $query->select('id', 'ruta_id');
        }])->whereBetween('fecha', [$FI, $FF])->get();

        return response()->json([
            'data' => $cobradores,
            'utilidades' => $utilidades,
            'recaudos' => $recaudos,
            'nuevos' => $nuevos,
            'renovaciones' => $renovaciones
        ]);
    }
}
