<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * 
 * @property int $id
 * @property string $nombres
 * @property string $apellidos
 * @property string $telefono1
 * @property string $telefono2
 * @property bool $login
 * @property string $username
 * @property string $password
 * @property int $ruta
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $email
 * @property int $rol
 * 
 * @property \Illuminate\Database\Eloquent\Collection $creditos_detalles
 *
 * @package App\Models
 */
class User extends Eloquent
{
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
		'email',
		'rol'
	];

	public function creditos_detalles()
	{
		return $this->hasMany(\App\Models\CreditosDetalle::class, 'usuario_id');
	}
}
