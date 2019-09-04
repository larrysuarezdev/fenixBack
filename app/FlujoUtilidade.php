<?php

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

class FlujoUtilidade extends Eloquent
{
	protected $casts = [
		'valor' => 'float',
		'tipo' => 'int'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'descripcion',
		'valor',
		'tipo',
		'fecha'
	];
}
