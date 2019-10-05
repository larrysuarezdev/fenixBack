<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	// use Authenticatable, Authorizable, CanResetPassword;
	protected $table = 'users';

	protected $primaryKey = 'id';

	protected $casts = [
		'login' => 'bool',
		'ruta' => 'int',
		'rol' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'nombres',
		'apellidos',
		'telefono1',
		'telefono2',
		'login',
		'username',
		'password',
		'ruta',
		'rol',
		'email'
	];

	public function coteos()
	{
		return $this->hasMany(\App\Coteo::class, 'id_usuario');
	}

	public function creditos_detalles()
	{
		return $this->hasMany(\App\CreditosDetalle::class, 'usuario_id');
	}
}
