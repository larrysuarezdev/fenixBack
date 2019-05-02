<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 24 Apr 2019 14:18:10 -0500.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

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
		return $this->belongsTo(\App\Parametro::class);
	}
}
