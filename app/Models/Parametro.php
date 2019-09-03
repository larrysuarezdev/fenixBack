<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Parametro
 * 
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property bool $editable
 * @property string $icono
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
		'editable',
		'icono'
	];

	public function parametros_detalles()
	{
		return $this->hasMany(\App\Models\ParametrosDetalle::class);
	}
}
