<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 11 Aug 2019 19:48:52 -0500.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

class RolesPermiso extends Eloquent
{
	protected $table = 'roles_permiso';
	public $timestamps = false;

	protected $casts = [
		'rol_id' => 'int',
		'ver' => 'bool'
	];

	protected $fillable = [
		'rol_id',
		'pantalla',
		'ver'
	];
}
