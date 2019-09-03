<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 21:26:08 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ParametrosDetalle
 * 
 * @property int $id
 * @property int $parametro_id
 * @property int $id_interno
 * @property string $valor
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Parametro $parametro
 *
 * @package App\Models
 */
class ParametrosDetalle extends Eloquent
{
	protected $casts = [
		'parametro_id' => 'int',
		'id_interno' => 'int'
	];

	protected $fillable = [
		'parametro_id',
		'id_interno',
		'valor'
	];

	public function parametro()
	{
		return $this->belongsTo(\App\Models\Parametro::class);
	}
}
