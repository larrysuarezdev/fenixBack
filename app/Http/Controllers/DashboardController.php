<?php

namespace App\Http\Controllers;
use App\Cliente;
use Carbon\Carbon;
// use Illuminate\Http\Request;
// use App\Http\Requests;

class DashboardController extends Controller
{
    public function getNewClientes()
    {
        $ageFrom = Carbon::now()->startOfMonth();
        $ageTo   = Carbon::now()->endOfMonth();

        error_log($ageFrom);
        error_log($ageTo);
        $clientesNew = Cliente::whereBetween('created_at', [$ageFrom, $ageTo])->get()->count();
        return response()->json(['clientesNew' => $clientesNew]);
    }
}
