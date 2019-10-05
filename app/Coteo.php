<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 02 Oct 2019 11:37:27 -0500.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

class Coteo extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'coteos_dia' => 'int',
		'id_ruta' => 'int',
		'id_usuario' => 'int',
		'total_creditos_dia' => 'int',		
		'total_creditos_sem' => 'int',		
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'fecha',
		'coteos_dia',
		'id_ruta',
		'total_creditos_dia',
		'total_creditos_sem',
		'id_usuario'
	];

	public function user()
	{
		return $this->belongsTo(\App\User::class, 'id_usuario');
	}
}
