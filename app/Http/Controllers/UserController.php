<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use App\ParametrosDetalle;
use App\RolesPermiso;
use JWTAuth;
use Hash as Hash;

class UserController extends Controller
{

	public function postSignIn(Requests\PostSignInRequest $request)
	{
		$input = $request->all();
		$credentials = [
			'Username' => $input['username'],
			'Password' => $input['password'],
		];

		$user = User::where('Username', $credentials['Username'])->first();
		$rol = ParametrosDetalle::where([['parametro_id', 1], ['id_interno', $user->rol ]])->first();
		// var_dump($rol);

		$rolesPermiso = RolesPermiso::where([['rol_id', $rol->id_interno], ['ver', true]])->get();
		
		if ($user) {
			$hashed = Hash::make($credentials['Password']);
			if (Hash::check($user->password, $hashed)) {
				$token = JWTAuth::fromUser($user);
				return response()->json(['token' => $token, 'user' => $user, 'rol' => $rolesPermiso]);
			}
		}

		return response()->json(['Error' => 'Nombre de usuario y/o contraseña invalida'], 401);
	}

	public function getUsers()
	{
		$user = JWTAuth::parseToken()->authenticate();
		$personas = User::get();

		return response()->json(['data' => $personas]);
	}

	public function saveUser(Requests\UserRequest $request)
	{
		$input = $request->all();
		$persona = new User;
		$persona->nombres = $input["nombres"];
		$persona->apellidos = $input["apellidos"];
		$persona->telefono1 = $input["telefono1"];
		$persona->telefono2 = $input["telefono2"];
		$persona->login = $input["login"];
		if ($input["login"]) {
			$persona->email = $input["email"];
			$persona->username = $input["username"];
			$persona->rol = $input["rol"];
			if ($request->has('password')) {
				$persona->password = $input["password"];				
			} 
		} else {
			$persona->ruta = $input["ruta"];
		}

		$persona->save();
		$personas = User::get();

		return response()->json(['data' => $personas]);
	}

	public function updateUser(Requests\UserRequest $request)
	{
		$input = $request->all();

		$persona = User::find($input["id"]);

		$persona->nombres = $input["nombres"];
		$persona->apellidos = $input["apellidos"];
		$persona->telefono1 = $input["telefono1"];
		$persona->telefono2 = $input["telefono2"];
		$persona->login = $input["login"];
		if ($input["login"]) {
			$persona->email = $input["email"];
			$persona->username = $input["username"];
			$persona->rol = $input["rol"];
			if ($request->has('password')) {
				$persona->password = $input["password"];				
			} 
		} else {
			$persona->ruta = $input["ruta"];
		}

		$persona->save();
		$personas = User::get();

		return response()->json(['data' => $personas]);
	}

	public function changePassword(Requests\PasswordResetRequest $request)
	{
		$input = $request->all();

		$persona = User::find($input["userId"]);
		$persona->password = $input["password"];
		$persona->save();
	}
}
