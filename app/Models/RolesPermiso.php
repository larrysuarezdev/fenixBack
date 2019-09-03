<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class RolesPermiso
 * 
 * @property int $id
 * @property int $rol_id
 * @property string $pantalla
 * @property bool $ver
 *
 * @package App\Models
 */
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
