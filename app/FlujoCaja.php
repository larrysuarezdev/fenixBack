<?php

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

class FlujoCaja extends Eloquent
{
	protected $table = 'flujo_caja';

	protected $casts = [
		'tipo' => 'int',
		'valor' => 'float'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'descripcion',
		'tipo',
		'valor',
		'fecha'
	];
}
