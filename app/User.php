<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	// use Authenticatable, Authorizable, CanResetPassword;
	protected $table = 'users';

	protected $primaryKey = 'id';

	protected $casts = [
		'login' => 'bool'
	];

	protected $fillable = [
		'nombres',
		'apellidos',
		'telefono1',
		'telefono2',
		'login',
		'email',
		'username',
		'password'
	];

	public function creditos_detalles()
	{
		return $this->hasMany(\App\CreditosDetalle::class, 'usuario_id');
	}
}
