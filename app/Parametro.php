<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 24 Apr 2019 14:18:10 -0500.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Parametro
 * 
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property bool $editable
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $parametros_detalles
 *
 * @package App\Models
 */
class Parametro extends Eloquent
{
	protected $casts = [
		'editable' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'descripcion',
		'icono',
		'editable'
	];

	public function parametros_detalles()
	{
		return $this->hasMany(\App\ParametrosDetalle::class);
	}
}
