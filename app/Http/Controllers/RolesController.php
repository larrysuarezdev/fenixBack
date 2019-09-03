<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\RolesPermiso;

class RolesController extends Controller
{
    public function getPermisoByRol($id)
    {
        $roles = RolesPermiso::where('rol_id', $id)->get();
        return response()->json(['data' => $roles]);
    }

    public function putPermisos(Request $request)
    {
        foreach ($request->all()['data'] as $input) {
            $rol = RolesPermiso::find($input['id']);
            $rol->ver = $input['ver'];
            $rol->save();
        }
        return response()->json(['data' => "Ok"]);
    }
}
