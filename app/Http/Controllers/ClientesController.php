<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Cliente;
use JWTAuth;

class ClientesController extends Controller
{
    public function getClientes()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $clientes = Cliente::get();

        return response()->json(['data' => $clientes]);
    }

    public function saveCliente(Requests\ClienteRequest $request)
    {
        $input = $request->all();

        $cliente = new Cliente;
        $cliente->titular = $input["titular"];
        $cliente->cc_titular = $input["cc_titular"];
        $cliente->fiador = $input["fiador"];
        $cliente->cc_fiador = $input["cc_fiador"];
        $cliente->neg_titular = $input["neg_titular"];
        $cliente->neg_fiador = $input["neg_fiador"];
        $cliente->dir_cobro = $input["dir_cobro"];
        $cliente->tel_cobro = $input["tel_cobro"];
        $cliente->barrio_cobro = $input["barrio_cobro"];
        $cliente->dir_casa = $input["dir_casa"];
        $cliente->barrio_casa = $input["barrio_casa"];
        $cliente->tel_casa = $input["tel_casa"];
        $cliente->dir_fiador = $input["dir_fiador"];
        $cliente->barrio_fiador = $input["barrio_fiador"];
        $cliente->tel_fiador = $input["tel_fiador"];

        $cliente->save();
        $clientes = Cliente::get();

        return response()->json(['data' => $clientes]);
    }

    public function updateCliente(Requests\ClienteRequest $request)
	{
		$input = $request->all();

        $cliente = Cliente::find($input["id"]);
        		
		$cliente->titular = $input["titular"];
        $cliente->cc_titular = $input["cc_titular"];
        $cliente->fiador = $input["fiador"];
        $cliente->cc_fiador = $input["cc_fiador"];
        $cliente->neg_titular = $input["neg_titular"];
        $cliente->neg_fiador = $input["neg_fiador"];
        $cliente->dir_cobro = $input["dir_cobro"];
        $cliente->tel_cobro = $input["tel_cobro"];
        $cliente->barrio_cobro = $input["barrio_cobro"];
        $cliente->dir_casa = $input["dir_casa"];
        $cliente->barrio_casa = $input["barrio_casa"];
        $cliente->tel_casa = $input["tel_casa"];
        $cliente->dir_fiador = $input["dir_fiador"];
        $cliente->barrio_fiador = $input["barrio_fiador"];
        $cliente->tel_fiador = $input["tel_fiador"];

		$cliente->save();
		$clientes = Cliente::get();

		return response()->json(['data' => $clientes]);
	}
}