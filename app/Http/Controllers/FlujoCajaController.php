<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\FlujoCaja;


class FlujoCajaController extends Controller
{
    
    public function getFlujoCaja()
    {
        $flujoCaja = FlujoCaja::get();

        return response()->json(['data' => $flujoCaja]);
    }
}
