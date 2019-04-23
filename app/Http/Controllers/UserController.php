<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Lib\LDAP as LDAP;
use App\User;
use App\Persona;
use App\Recomendacione;
use JWTAuth;
use Hash as Hash;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function __construct(LDAP $ldap)
	{ }

	public function postSignIn(Requests\PostSignInRequest $request)
	{
		$input = $request->all();
		$credentials = [
			'Username' => $input['username'],
			'Password' => $input['password'],
		];

		$user = User::where('Username', $credentials['Username'])->first();
		
		if ($user) {
			$hashed = Hash::make($credentials['Password']);
			if (Hash::check($user->password, $hashed)) {
				$token = JWTAuth::fromUser($user);
				return response()->json(['token' => $token, 'user' => $user]);
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
		$persona->username = $input["username"];
		$persona->password = $input["password"];
		
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
		$persona->username = $input["username"];
		$persona->password = $input["password"];

		$persona->save();
		$personas = User::get();

		return response()->json(['data' => $personas]);
	}

	
}
